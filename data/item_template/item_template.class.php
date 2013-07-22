<?php
/**
 * Class Item_Template
 *
 */

require_once( DATA."model/item_template_model.class.php" );

class Item_Template extends Item_Template_Model {

  // CUSTOM

	public function is_edible() {
		// 8 = Feeding
		$ability_list = $this->get_item_template_ability_list(8);
		return count( $ability_list ) == 1;
	}
	
	public function get_ability_points_provided( $ability_id ) {
		$return = 0;
		$ability_list = $this->get_item_template_ability_list($ability_id);
		
		if( count( $ability_list ) == 1 ) {
			$item_ability = array_pop($ability_list);
			$return = $item_ability['points_provided'];
		}
		return $return;
	}

  // /CUSTOM

}