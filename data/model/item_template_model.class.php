<?php
/**
 * Classe Item_Template
 *
 */

class Item_Template_Model extends DBObject {
  // Champs BD
  protected $_name = null;
  protected $_tech = null;
  protected $_type_id = null;
  protected $_obsolete = null;
  protected $_next_item_template_id = null;

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "item_template"; }


  /* MUTATEURS */
  public function set_tech($tech) {
    if( is_numeric($tech) && (int)$tech == $tech) $data = intval($tech); else $data = null; $this->_tech = $data;
  }
  public function set_obsolete($obsolete) {
    if( is_numeric($obsolete) && (int)$obsolete == $obsolete) $data = intval($obsolete); else $data = null; $this->_obsolete = $data;
  }

  /* FONCTIONS SQL */


  public static function db_get_by_type_id($type_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `type_id` = ".mysql_ureal_escape_string($type_id);

    return self::sql_to_list($sql);
  }
  public static function db_get_by_next_item_template_id($next_item_template_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `next_item_template_id` = ".mysql_ureal_escape_string($next_item_template_id);

    return self::sql_to_list($sql);
  }

  public static function db_get_select_list( $with_null = false ) {
    $return = array();

    if( $with_null ) {
        $return[ null ] = 'N/A';
    }

    $object_list = Item_Template_Model::db_get_all();
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
        </p>
        <p class="field">'.(is_array($this->get_tech())?
          HTMLHelper::genererTextArea( "tech", parameters_to_string( $this->get_tech() ), array(), "Tech" ):
          HTMLHelper::genererInputText( "tech", $this->get_tech(), array(), "Tech")).'
        </p>';
      $option_list = array();
      $item_type_list = Item_Type::db_get_all();
      foreach( $item_type_list as $item_type)
        $option_list[ $item_type->id ] = $item_type->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('type_id', $option_list, $this->get_type_id(), array(), "Type Id *").'<a href="'.get_page_url('admin_item_type_mod').'">Créer un objet Item Type</a></p>
        <p class="field">'.(is_array($this->get_obsolete())?
          HTMLHelper::genererTextArea( "obsolete", parameters_to_string( $this->get_obsolete() ), array(), "Obsolete" ):
          HTMLHelper::genererInputText( "obsolete", $this->get_obsolete(), array(), "Obsolete")).'
        </p>';
      $option_list = array("null" => 'Pas de choix');
      $item_template_list = Item_Template::db_get_all();
      foreach( $item_template_list as $item_template)
        $option_list[ $item_template->id ] = $item_template->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('next_item_template_id', $option_list, $this->get_next_item_template_id(), array(), "Next Item Template Id").'<a href="'.get_page_url('admin_item_template_mod').'">Créer un objet Item Template</a></p>

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
      case 2 : $return = "Le champ <strong>Type Id</strong> est obligatoire."; break;
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
    $return[] = Member::check_compulsory($this->get_type_id(), 2);

    $return = array_unique($return);
    if(($true_key = array_search(true, $return, true)) !== false) {
      unset($return[$true_key]);
    }
    if(count($return) == 0) $return = true;
    return $return;
  }

  public function get_item_template_ability_list($ability_id = null) {
    $where = '';
    if( ! is_null( $ability_id )) $where .= '
AND `ability_id` = '.mysql_ureal_escape_string($ability_id);

    $sql = '
SELECT `item_template_id`, `ability_id`, `points_provided`
FROM `item_template_ability`
WHERE `item_template_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_item_template_ability( $ability_id, $points_provided ) {
    $sql = "REPLACE INTO `item_template_ability` ( `item_template_id`, `ability_id`, `points_provided` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $ability_id, $points_provided ).")";

    return mysql_uquery($sql);
  }

  public function del_item_template_ability( $ability_id = null ) {
    $where = '';
    if( ! is_null( $ability_id )) $where .= '
AND `ability_id` = '.mysql_ureal_escape_string($ability_id);
    $sql = 'DELETE FROM `item_template_ability`
    WHERE `item_template_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_recipe_byproduct_list($recipe_id = null) {
    $where = '';
    if( ! is_null( $recipe_id )) $where .= '
AND `recipe_id` = '.mysql_ureal_escape_string($recipe_id);

    $sql = '
SELECT `recipe_id`, `item_template_id`, `quantity`
FROM `recipe_byproduct`
WHERE `item_template_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_recipe_byproduct( $recipe_id, $quantity ) {
    $sql = "REPLACE INTO `recipe_byproduct` ( `recipe_id`, `item_template_id`, `quantity` ) VALUES (".mysql_ureal_escape_string( $recipe_id, $this->get_id(), $quantity ).")";

    return mysql_uquery($sql);
  }

  public function del_recipe_byproduct( $recipe_id = null ) {
    $where = '';
    if( ! is_null( $recipe_id )) $where .= '
AND `recipe_id` = '.mysql_ureal_escape_string($recipe_id);
    $sql = 'DELETE FROM `recipe_byproduct`
    WHERE `item_template_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_recipe_consumable_list($recipe_id = null) {
    $where = '';
    if( ! is_null( $recipe_id )) $where .= '
AND `recipe_id` = '.mysql_ureal_escape_string($recipe_id);

    $sql = '
SELECT `recipe_id`, `item_template_id`, `quantity`
FROM `recipe_consumable`
WHERE `item_template_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_recipe_consumable( $recipe_id, $quantity ) {
    $sql = "REPLACE INTO `recipe_consumable` ( `recipe_id`, `item_template_id`, `quantity` ) VALUES (".mysql_ureal_escape_string( $recipe_id, $this->get_id(), $quantity ).")";

    return mysql_uquery($sql);
  }

  public function del_recipe_consumable( $recipe_id = null ) {
    $where = '';
    if( ! is_null( $recipe_id )) $where .= '
AND `recipe_id` = '.mysql_ureal_escape_string($recipe_id);
    $sql = 'DELETE FROM `recipe_consumable`
    WHERE `item_template_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }







  // CUSTOM

  //Custom content

  // /CUSTOM

}