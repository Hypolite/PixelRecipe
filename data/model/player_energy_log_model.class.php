<?php
/**
 * Classe Player_Energy_Log
 *
 */

class Player_Energy_Log_Model extends DBObject {
  // Champs BD
  protected $_player_id = null;
  protected $_reason = null;
  protected $_delta = null;
  protected $_timestamp = null;

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "player_energy_log"; }

  public function get_timestamp()    { return guess_time($this->_timestamp);}

  /* MUTATEURS */
  public function set_player_id($player_id) {
    if( is_numeric($player_id) && (int)$player_id == $player_id) $data = intval($player_id); else $data = null; $this->_player_id = $data;
  }
  public function set_delta($delta) {
    if( is_numeric($delta) && (int)$delta == $delta) $data = intval($delta); else $data = null; $this->_delta = $data;
  }
  public function set_timestamp($date) { $this->_timestamp = guess_time($date, GUESS_DATE_MYSQL);}

  /* FONCTIONS SQL */


  public static function db_get_by_player_id($player_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `player_id` = ".mysql_ureal_escape_string($player_id);

    return self::sql_to_list($sql);
  }

  public static function db_get_select_list( $with_null = false ) {
    $return = array();

    if( $with_null ) {
        $return[ null ] = 'N/A';
    }

    $object_list = Player_Energy_Log_Model::db_get_all();
    foreach( $object_list as $object ) $return[ $object->get_id() ] = $object->get_id();

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
        '.HTMLHelper::genererInputHidden('id', $this->get_id()).'';
      $option_list = array();
      $player_list = Player::db_get_all();
      foreach( $player_list as $player)
        $option_list[ $player->id ] = $player->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('player_id', $option_list, $this->get_player_id(), array(), "Player Id *").'<a href="'.get_page_url('admin_player_mod').'">Créer un objet Player</a></p>
        <p class="field">'.(is_array($this->get_reason())?
          HTMLHelper::genererTextArea( "reason", parameters_to_string( $this->get_reason() ), array(), "Reason *" ):
          HTMLHelper::genererInputText( "reason", $this->get_reason(), array(), "Reason *")).'
        </p>
        <p class="field">'.(is_array($this->get_delta())?
          HTMLHelper::genererTextArea( "delta", parameters_to_string( $this->get_delta() ), array(), "Delta *" ):
          HTMLHelper::genererInputText( "delta", $this->get_delta(), array(), "Delta *")).'
        </p>
        <p class="field">'.(is_array($this->get_timestamp())?
          HTMLHelper::genererTextArea( "timestamp", parameters_to_string( $this->get_timestamp() ), array(), "Timestamp *" ):
          HTMLHelper::genererInputText( "timestamp", $this->get_timestamp(), array(), "Timestamp *")).'
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
      case 1 : $return = "Le champ <strong>Player Id</strong> est obligatoire."; break;
      case 2 : $return = "Le champ <strong>Reason</strong> est obligatoire."; break;
      case 3 : $return = "Le champ <strong>Delta</strong> est obligatoire."; break;
      case 4 : $return = "Le champ <strong>Timestamp</strong> est obligatoire."; break;
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

    $return[] = Member::check_compulsory($this->get_player_id(), 1, true);
    $return[] = Member::check_compulsory($this->get_reason(), 2);
    $return[] = Member::check_compulsory($this->get_delta(), 3, true);
    $return[] = Member::check_compulsory($this->get_timestamp(), 4);

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