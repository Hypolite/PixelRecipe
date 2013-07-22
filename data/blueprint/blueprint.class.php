<?php
/**
 * Class Blueprint
 *
 */

require_once( DATA."model/blueprint_model.class.php" );

class Blueprint extends Blueprint_Model {

  // CUSTOM

	public static function get_gather_list(){
		$sql = '
SELECT r.*
FROM `'.self::get_table_name().'` r
LEFT JOIN `blueprint_consumable` r_c ON r_c.`blueprint_id` = r.`id`
WHERE r_c.`blueprint_id` IS NULL';

		return self::sql_to_list($sql);
	}

	public function get_consumable_list(){
		$sql = '
SELECT *
FROM `item_template` i_t
JOIN `blueprint_consumable` r_c ON r_c.`item_template_id` = i_t.`id`
WHERE r_c.`blueprint_id` = '.mysql_ureal_escape_string($this->id);

		return Item_Template::sql_to_list($sql);
	}

	public function get_byproduct_list(){
		$sql = '
SELECT *
FROM `item_template` i_t
JOIN `blueprint_byproduct` r_c ON r_c.`item_template_id` = i_t.`id`
WHERE r_c.`blueprint_id` = '.mysql_ureal_escape_string($this->id);

		return Item_Template::sql_to_list($sql);
	}

	public static function get_available_blueprint_list( Player $player ) {
		$sql = '
SELECT r.*
FROM `blueprint` r
JOIN `blueprint_consumable` r_c ON r_c.`blueprint_id` = r.`id`
JOIN (
	SELECT `item_template_id`, COUNT(*) AS `quantity`
	FROM `item`
	WHERE `owner_id` = '.  mysql_ureal_escape_string($player->id).'
	AND `destroyed` IS NULL
	GROUP BY `item_template_id`
) `p_i`
ON p_i.`item_template_id` = r_c.`item_template_id` AND p_i.`quantity` >= r_c.`quantity`';

		return Blueprint::sql_to_list($sql);
	}


  // /CUSTOM

}