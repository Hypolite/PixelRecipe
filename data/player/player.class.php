<?php
/**
 * Class Player
 *
 */

require_once( DATA."model/player_model.class.php" );

class Player extends Player_Model {

  // CUSTOM

	public static function db_get_by_member_id( $member_id ) {
		$sql = "
SELECT *
FROM `".self::get_table_name()."`
WHERE `member_id` = ".mysql_ureal_escape_string( $member_id );

		return self::sql_to_list( $sql );
	}

	public static function get_current( Member $member ) {
		$return = null;
		if( !isset( $_SESSION['current_player_id'] ) ) {
			$player_list = Player::db_get_by_member_id( $member->id );
			$_SESSION['current_player_id'] = null;
			if( count( $player_list ) ) {
				 $player = array_shift( $player_list );
				 $_SESSION['current_player_id'] = $player->id;
				 $return = $player;
			}
		}else {
			$return = Player::instance( $_SESSION['current_player_id'] );
		}

		return $return;
	}

	public static function set_current( Player $player ) {
		$_SESSION['current_player_id'] = $player->id;

		return true;
	}

	public function can_create_player( Member $member ) {
		$return = is_admin();
		if( !$return ) {
			$sql = '
SELECT COUNT(*)
FROM `player`
WHERE `member_id` = '.$member->id;
			$res = mysql_uquery($sql);
			$count = array_pop( mysql_fetch_row($res) );

			$return = $count < 2;
		}
		return $return;
	}

	public function can_cook( Recipe $recipe ) {
		$return = true;

		// Check consumables (type + quantity)

		// Check tools

		return $return;
	}
        
	public function get_current_energy() {
		$sql = '
SELECT IFNULL(SUM(`time_taken`), 0)
FROM `player_recipe_log`
WHERE `player_id` = '.mysql_ureal_escape_string($this->id);
		$res = mysql_uquery($sql);
		$energy_consumed = array_pop(mysql_fetch_row($res));
		
		$sql = '
SELECT IFNULL(SUM(`delta`), 0)
FROM `player_energy_log`
WHERE `player_id` = '.mysql_ureal_escape_string($this->id);
		$res = mysql_uquery($sql);
		$energy_gained = array_pop(mysql_fetch_row($res));
		
		return $energy_gained - $energy_consumed;
	}

	public function get_inventory_list() {
		$sql = '
SELECT *
FROM `item`
WHERE `owner_id` = '.mysql_ureal_escape_string($this->id).'
AND `destroyed` IS NULL';

		return Item::sql_to_list($sql);
	}

	public function search_items( Item_Template $item_template, $quantity = null ) {
		$limit = '';
		if( $quantity !== null ) {
			$limit = '
LIMIT 0, '.(int)$quantity;
		}

		$sql = '
SELECT *
FROM `item`
WHERE `owner_id` = '.mysql_ureal_escape_string($this->id).'
AND `destroyed` IS NULL
AND `item_template_id` = '.mysql_ureal_escape_string($item_template->id).'
ORDER BY `clock` DESC'.$limit;

		return Item::sql_to_list($sql);
	}

	public function gain_item( Item_Template $item_template ) {
		// Create a new item from the item template
		$item = Item::create_from_template( $item_template );

		// Give it to the player
		$item->owner_id = $this->id;

		$item->save();

		return $item;
	}

	public function lose_item( Item_Template $item_template, $quantity = 1 ) {
		// Look for an item in player's inventory
		$item_list = $this->search_items( $item_template, $quantity );

		if( count($item_list) == $quantity ) {
			// Destroy the items
			foreach ($item_list as $item) {
				$item->destroy();
			}

		}else {
			throw new Exception("You have only ".count($item_list)." out of ".$quantity." required items of ".$item_template->name);
		}

		return true;
	}
	
	public function eat(Item $item) {
		if( $item->id === null )
			throw new Exception('Non-existing item.');
			
		if( $item->owner_id != $this->id )
			throw new Exception('Item '.$item->name.' doesn\'t belong to you.');
		
		if( $item->destroyed )
			throw new Exception('Item '.$item->name.' is destroyed.');
		
		if( $this->current_energy >= $this->max_energy )
			throw new Exception('You are already full.');
		
		/* @var $item_template Item_Template */
		$item_template = Item_Template::instance($item->item_template_id);
		// 8 = Feeding
		$ability_list = $item_template->get_item_template_ability_list(8);
		if( count( $ability_list ) == 0 )
			throw new Exception('Item '.$item->name.' is not edible.');
		
		$feeding_ability = array_pop($ability_list);
		
		$player_energy_log = Player_Energy_Log::instance();
		$player_energy_log->player_id = $this->id;
		$player_energy_log->reason = 'Food';
		$player_energy_log->delta = $feeding_ability['points_provided'];
		$player_energy_log->timestamp = time();
		$player_energy_log->save();
		
		$item->destroy();
	}

	public function cook( Recipe $recipe ) {
		mysql_uquery('BEGIN');

		try {
			$time_taken = $recipe->time;
			
			if( $time_taken > $this->current_energy )
				throw new Exception('You don\'t have enough energy to craft this item.');
			
			// Remove Consumables from player's inventory
			$consumable_list = $recipe->get_consumable_list();

			foreach( $consumable_list as $consumable ) {
				$item_template = Item_Template::instance($consumable['item_template_id']);
				$this->lose_item( $item_template, $consumable['quantity'] );
			}

			// Add the Byproducts to player's inventory
			$byproduct_list = $recipe->get_byproduct_list();

			foreach( $byproduct_list as $byproduct ) {
				$item_template = Item_Template::instance($byproduct['item_template_id']);
				for($i = 0; $i < $byproduct['quantity']; $i++) {
					$this->gain_item( $byproduct );				
				}
			}

			// Add the result to player's inventory
			$result = Item_Template::instance($recipe->item_template_id);
			$this->gain_item( $result );

			// Make time pass for the player's inventory
			$this->pass_time($time_taken);

			// Increase according player's skill
			//$recipe_skill = Skill::instance($recipe->skill_id);
			//$this->increase_skill( $recipe_skill, $time_taken );

			// Add a log entry
			$log_entry = Player_Recipe_Log::instance();
			$log_entry->player_id = $this->id;
			$log_entry->recipe_id = $recipe->id;
			$log_entry->time_taken = $time_taken;
			$log_entry->timestamp = guess_time(time(), GUESS_DATE_MYSQL);
			$log_entry->save();

			mysql_uquery('COMMIT');
			$return = true;
		}catch(Exception $e) {
			mysql_uquery('ROLLBACK');

			throw $e;
			$return = $e->getCode();
		}

		return $return;
	}

	public function pass_time( $time ) {
		$item_list = $this->get_inventory_list();

		foreach( $item_list as $item ) {
			$item->pass_time( $time );
		}
	}

  // /CUSTOM

}