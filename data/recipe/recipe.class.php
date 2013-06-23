<?php
/**
 * Class Recipe
 *
 */

require_once( DATA."model/recipe_model.class.php" );

class Recipe extends Recipe_Model {

  // CUSTOM

  public static function get_gather_list(){
	  $sql = '
SELECT r.*
FROM `'.self::get_table_name().'` r
LEFT JOIN `recipe_consumable` r_c ON r_c.`recipe_id` = r.`id`
WHERE r_c.`recipe_id` IS NULL';

    return self::sql_to_list($sql);
  }

  // /CUSTOM

}