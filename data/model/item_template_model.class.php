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

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "item_template"; }


  /* MUTATEURS */
  public function set_tech($tech) {
    if( is_numeric($tech) && (int)$tech == $tech) $data = intval($tech); else $data = null; $this->_tech = $data;
  }

  /* FONCTIONS SQL */


  public static function db_get_by_type_id($type_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `type_id` = ".mysql_ureal_escape_string($type_id);

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
        </p>
        <p class="field">'.(is_array($this->get_type_id())?
          HTMLHelper::genererTextArea( "type_id", parameters_to_string( $this->get_type_id() ), array(), "Type Id *" ):
          HTMLHelper::genererInputText( "type_id", $this->get_type_id(), array(), "Type Id *")).'
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





  // CUSTOM

  //Custom content

  // /CUSTOM

}