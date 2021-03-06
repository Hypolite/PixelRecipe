<?php
/**
 * Classe Item
 *
 */

class Item_Model extends DBObject {
  // Champs BD
  protected $_name = null;
  protected $_item_template_id = null;
  protected $_owner_id = null;
  protected $_quality = null;
  protected $_clock = null;
  protected $_obsolete = null;
  protected $_created = null;
  protected $_destroyed = null;

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "item"; }

  public function get_created()    { return guess_time($this->_created);}
  public function get_destroyed()    { return guess_time($this->_destroyed);}

  /* MUTATEURS */
  public function set_owner_id($owner_id) {
    if( is_numeric($owner_id) && (int)$owner_id == $owner_id) $data = intval($owner_id); else $data = null; $this->_owner_id = $data;
  }
  public function set_clock($clock) {
    if( is_numeric($clock) && (int)$clock == $clock) $data = intval($clock); else $data = null; $this->_clock = $data;
  }
  public function set_obsolete($obsolete) {
    if( is_numeric($obsolete) && (int)$obsolete == $obsolete) $data = intval($obsolete); else $data = null; $this->_obsolete = $data;
  }
  public function set_created($date) { $this->_created = guess_time($date, GUESS_DATE_MYSQL);}
  public function set_destroyed($date) { $this->_destroyed = guess_time($date, GUESS_DATE_MYSQL);}

  /* FONCTIONS SQL */


  public static function db_get_by_item_template_id($item_template_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `item_template_id` = ".mysql_ureal_escape_string($item_template_id);

    return self::sql_to_list($sql);
  }
  public static function db_get_by_owner_id($owner_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `owner_id` = ".mysql_ureal_escape_string($owner_id);

    return self::sql_to_list($sql);
  }

  public static function db_get_select_list( $with_null = false ) {
    $return = array();

    if( $with_null ) {
        $return[ null ] = 'N/A';
    }

    $object_list = Item_Model::db_get_all();
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
      $player_list = Player::db_get_all();
      foreach( $player_list as $player)
        $option_list[ $player->id ] = $player->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('owner_id', $option_list, $this->get_owner_id(), array(), "Owner Id").'<a href="'.get_page_url('admin_player_mod').'">Créer un objet Player</a></p>
        <p class="field">'.(is_array($this->get_quality())?
          HTMLHelper::genererTextArea( "quality", parameters_to_string( $this->get_quality() ), array(), "Quality" ):
          HTMLHelper::genererInputText( "quality", $this->get_quality(), array(), "Quality")).'
        </p>
        <p class="field">'.(is_array($this->get_clock())?
          HTMLHelper::genererTextArea( "clock", parameters_to_string( $this->get_clock() ), array(), "Clock *" ):
          HTMLHelper::genererInputText( "clock", $this->get_clock(), array(), "Clock *")).'
        </p>
        <p class="field">'.(is_array($this->get_obsolete())?
          HTMLHelper::genererTextArea( "obsolete", parameters_to_string( $this->get_obsolete() ), array(), "Obsolete" ):
          HTMLHelper::genererInputText( "obsolete", $this->get_obsolete(), array(), "Obsolete")).'
        </p>
        <p class="field">'.(is_array($this->get_created())?
          HTMLHelper::genererTextArea( "created", parameters_to_string( $this->get_created() ), array(), "Created *" ):
          HTMLHelper::genererInputText( "created", $this->get_created(), array(), "Created *")).'
        </p>
        <p class="field">'.(is_array($this->get_destroyed())?
          HTMLHelper::genererTextArea( "destroyed", parameters_to_string( $this->get_destroyed() ), array(), "Destroyed" ):
          HTMLHelper::genererInputText( "destroyed", $this->get_destroyed(), array(), "Destroyed")).'
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
      case 3 : $return = "Le champ <strong>Clock</strong> est obligatoire."; break;
      case 4 : $return = "Le champ <strong>Created</strong> est obligatoire."; break;
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
    $return[] = Member::check_compulsory($this->get_clock(), 3, true);
    $return[] = Member::check_compulsory($this->get_created(), 4);

    $return = array_unique($return);
    if(($true_key = array_search(true, $return, true)) !== false) {
      unset($return[$true_key]);
    }
    if(count($return) == 0) $return = true;
    return $return;
  }





  // CUSTOM

  //Custom content

  // /CUSTOM

}