<?php
/**
 * Classe Recipe
 *
 */

class Recipe_Model extends DBObject {
  // Champs BD
  protected $_name = null;
  protected $_item_template_id = null;
  protected $_skill_id = null;
  protected $_time = null;

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "recipe"; }


  /* MUTATEURS */
  public function set_time($time) {
    if( is_numeric($time) && (int)$time == $time) $data = intval($time); else $data = null; $this->_time = $data;
  }

  /* FONCTIONS SQL */


  public static function db_get_by_item_template_id($item_template_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `item_template_id` = ".mysql_ureal_escape_string($item_template_id);

    return self::sql_to_list($sql);
  }
  public static function db_get_by_skill_id($skill_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `skill_id` = ".mysql_ureal_escape_string($skill_id);

    return self::sql_to_list($sql);
  }

  public static function db_get_select_list( $with_null = false ) {
    $return = array();

    if( $with_null ) {
        $return[ null ] = 'N/A';
    }

    $object_list = Recipe_Model::db_get_all();
    foreach( $object_list as $object ) $return[ $object->get_id() ] = $object->get_name();

    return $return;
  }

  /* FONCTIONS HTML */

  /**
   * Formulaire d'édition partie Administration
   *
   * @return string
   */
  public function html_get_form() {
    $return = '
    <fieldset>
      <legend>Text fields</legend>
        '.HTMLHelper::genererInputHidden('id', $this->get_id()).'
        <p class="field">'.(is_array($this->get_name())?
          HTMLHelper::genererTextArea( "name", parameters_to_string( $this->get_name() ), array(), "Name *" ):
          HTMLHelper::genererInputText( "name", $this->get_name(), array(), "Name *")).'
        </p>';
      $option_list = array();
      $item_template_list = Item_Template::db_get_all();
      foreach( $item_template_list as $item_template)
        $option_list[ $item_template->id ] = $item_template->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('item_template_id', $option_list, $this->get_item_template_id(), array(), "Item Template Id *").'<a href="'.get_page_url('admin_item_template_mod').'">Créer un objet Item Template</a></p>';
      $option_list = array("null" => 'Pas de choix');
      $skill_list = Skill::db_get_all();
      foreach( $skill_list as $skill)
        $option_list[ $skill->id ] = $skill->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('skill_id', $option_list, $this->get_skill_id(), array(), "Skill Id").'<a href="'.get_page_url('admin_skill_mod').'">Créer un objet Skill</a></p>
        <p class="field">'.(is_array($this->get_time())?
          HTMLHelper::genererTextArea( "time", parameters_to_string( $this->get_time() ), array(), "Time *" ):
          HTMLHelper::genererInputText( "time", $this->get_time(), array(), "Time *")).'
        </p>

    </fieldset>';

    return $return;
  }

/**
 * Retourne la chaîne de caractère d'erreur en fonction du code correspondant
 *
 * @see Member->check_valid
 * @param int $num_error Code d'erreur
 * @return string
 */
  public static function get_message_erreur($num_error) {
    switch($num_error) { 
      case 1 : $return = "Le champ <strong>Name</strong> est obligatoire."; break;
      case 2 : $return = "Le champ <strong>Item Template Id</strong> est obligatoire."; break;
      case 3 : $return = "Le champ <strong>Time</strong> est obligatoire."; break;
      default: $return = "Erreur de saisie, veuillez vérifier les champs.";
    }
    return $return;
  }

  /**
   * Effectue les vérifications basiques pour mettre à jour les champs
   * Retourne true si pas d'erreur, une liste de codes d'erreur sinon :
   *
   * @param int $flags Flags augmentant l'étendue des tests
   * @return true | array
   */
  public function check_valid($flags = 0) {
    $return = array();

    $return[] = Member::check_compulsory($this->get_name(), 1);
    $return[] = Member::check_compulsory($this->get_item_template_id(), 2);
    $return[] = Member::check_compulsory($this->get_time(), 3, true);

    $return = array_unique($return);
    if(($true_key = array_search(true, $return, true)) !== false) {
      unset($return[$true_key]);
    }
    if(count($return) == 0) $return = true;
    return $return;
  }

  public function get_recipe_ability_list($ability_id = null) {
    $where = '';
    if( ! is_null( $ability_id )) $where .= '
AND `ability_id` = '.mysql_ureal_escape_string($ability_id);

    $sql = '
SELECT `recipe_id`, `ability_id`, `points_needed`
FROM `recipe_ability`
WHERE `recipe_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_recipe_ability( $ability_id, $points_needed ) {
    $sql = "REPLACE INTO `recipe_ability` ( `recipe_id`, `ability_id`, `points_needed` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $ability_id, $points_needed ).")";

    return mysql_uquery($sql);
  }

  public function del_recipe_ability( $ability_id = null ) {
    $where = '';
    if( ! is_null( $ability_id )) $where .= '
AND `ability_id` = '.mysql_ureal_escape_string($ability_id);
    $sql = 'DELETE FROM `recipe_ability`
    WHERE `recipe_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_recipe_byproduct_list($item_template_id = null) {
    $where = '';
    if( ! is_null( $item_template_id )) $where .= '
AND `item_template_id` = '.mysql_ureal_escape_string($item_template_id);

    $sql = '
SELECT `recipe_id`, `item_template_id`, `quantity`
FROM `recipe_byproduct`
WHERE `recipe_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_recipe_byproduct( $item_template_id, $quantity ) {
    $sql = "REPLACE INTO `recipe_byproduct` ( `recipe_id`, `item_template_id`, `quantity` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $item_template_id, $quantity ).")";

    return mysql_uquery($sql);
  }

  public function del_recipe_byproduct( $item_template_id = null ) {
    $where = '';
    if( ! is_null( $item_template_id )) $where .= '
AND `item_template_id` = '.mysql_ureal_escape_string($item_template_id);
    $sql = 'DELETE FROM `recipe_byproduct`
    WHERE `recipe_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_recipe_consumable_list($item_template_id = null) {
    $where = '';
    if( ! is_null( $item_template_id )) $where .= '
AND `item_template_id` = '.mysql_ureal_escape_string($item_template_id);

    $sql = '
SELECT `recipe_id`, `item_template_id`, `quantity`
FROM `recipe_consumable`
WHERE `recipe_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_recipe_consumable( $item_template_id, $quantity ) {
    $sql = "REPLACE INTO `recipe_consumable` ( `recipe_id`, `item_template_id`, `quantity` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $item_template_id, $quantity ).")";

    return mysql_uquery($sql);
  }

  public function del_recipe_consumable( $item_template_id = null ) {
    $where = '';
    if( ! is_null( $item_template_id )) $where .= '
AND `item_template_id` = '.mysql_ureal_escape_string($item_template_id);
    $sql = 'DELETE FROM `recipe_consumable`
    WHERE `recipe_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }







  // CUSTOM

  //Custom content

  // /CUSTOM

}