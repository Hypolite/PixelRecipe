<?php
/**
 * Class Item
 *
 */

require_once( DATA."model/item_model.class.php" );

class Item extends Item_Model {

  // CUSTOM

	public static function create_from_template( Item_Template $item_template ) {
		$item = Item::instance();
		$item->item_template_id = $item_template->id;
		$item->name = $item_template->name;
		// TODO : Vary quality
		$item->quality = 100;
		$item->clock = 0;
		// TODO : Vary obsolete
		$item->obsolete = $item_template->obsolete;
		$item->created = guess_time(time(), GUESS_TIME_MYSQL);
		$result = $item->save();

		return $item;
	}

	public function pass_time( $time ) {
		$this->clock += $time;

		$this->save();

		$item_template = Item_Template::instance( $this->item_template_id );
		if( $this->obsolete != 0 && $this->clock >= $this->obsolete ) {
			$this->destroy();

			if( $item_template->next_item_template_id ) {
				$new_item_template = Item_Template::instance($item_template->next_item_template_id);

				$new_item = Item::create_from_template($new_item_template);

				$new_item->owner_id = $this->owner_id;
				$new_item->quality = $this->quality;
				$new_item->save();
			}
		}
	}

	public function destroy() {
		$this->destroyed = guess_time(time(), GUESS_TIME_MYSQL);
		$this->save();
	}

	public function is_edible() {
		/* @var $item_template Item_Template */
		$item_template = Item_Template::instance($this->item_template_id);

		return $item_template->is_edible();
	}

	public function get_ability_points_provided( $ability_id ) {
		/* @var $item_template Item_Template */
		$item_template = Item_Template::instance($this->item_template_id);

		return $item_template->get_ability_points_provided( $ability_id );
	}

  // /CUSTOM

}