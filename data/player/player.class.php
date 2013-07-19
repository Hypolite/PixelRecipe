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
			throw new Exception("You have ".count($item_list)." out of ".$quantity." required items of ".$item_template->name);
		}

		return true;
	}

	public function cook( Recipe $recipe ) {
		mysql_uquery('BEGIN');

		try {
			// Remove Consumables from player's inventory
			$consumable_list = $recipe->get_consumable_list();

			foreach( $consumable_list as $consumable ) {
				$this->lose_item( $consumable );
			}

			// Add the Byproducts to player's inventory
			$byproduct_list = $recipe->get_byproduct_list();

			foreach( $byproduct_list as $byproduct ) {
				$this->gain_item( $byproduct );
			}

			// Add the result to player's inventory
			$result = Item_Template::instance($recipe->item_template_id);
			$this->gain_item( $result );

			$time_taken = $recipe->time;

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