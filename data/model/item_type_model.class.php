<?php
/**
 * Classe Item_Type
 *
 */

class Item_Type_Model extends DBObject {
  // Champs BD
  protected $_name = null;

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "item_type"; }


  /* MUTATEURS */

  /* FONCTIONS SQL */



  public static function db_get_select_list( $with_null = false ) {
    $return = array();
    
    if( $with_null ) {
        $return[ null ] = 'N/A';
    }

    $object_list = Item_Type_Model::db_get_all();
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