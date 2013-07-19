<?php
/**
 * Classe Player
 *
 */

class Player_Model extends DBObject {
  // Champs BD
  protected $_member_id = null;
  protected $_name = null;
  protected $_active = null;
  protected $_api_key = null;
  protected $_created = null;

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "player"; }

  public function get_active() { return $this->is_active(); }
  public function is_active() { return ($this->_active == 1); }
  public function get_created()    { return guess_time($this->_created);}

  /* MUTATEURS */
  public function set_id($id) {
    if( is_numeric($id) && (int)$id == $id) $data = intval($id); else $data = null; $this->_id = $data;
  }
  public function set_member_id($member_id) {
    if( is_numeric($member_id) && (int)$member_id == $member_id) $data = intval($member_id); else $data = null; $this->_member_id = $data;
  }
  public function set_active($active) {
    if($active) $data = 1; else $data = 0; $this->_active = $data;
  }
  public function set_created($date) { $this->_created = guess_time($date, GUESS_DATE_MYSQL);}

  /* FONCTIONS SQL */


  public static function db_get_by_member_id($member_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `member_id` = ".mysql_ureal_escape_string($member_id);

    return self::sql_to_list($sql);
  }

  public static function db_get_select_list( $with_null = false ) {
    $return = array();

    if( $with_null ) {
        $return[ null ] = 'N/A';
    }

    $object_list = Player_Model::db_get_all();
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
        '.HTMLHelper::genererInputHidden('id', $this->get_id()).'';
      $option_list = array();
      $member_list = Member::db_get_all();
      foreach( $member_list as $member)
        $option_list[ $member->id ] = $member->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('member_id', $option_list, $this->get_member_id(), array(), "Member Id *").'<a href="'.get_page_url('admin_member_mod').'">Créer un objet Member</a></p>
        <p class="field">'.(is_array($this->get_name())?
          HTMLHelper::genererTextArea( "name", parameters_to_string( $this->get_name() ), array(), "Name *" ):
          HTMLHelper::genererInputText( "name", $this->get_name(), array(), "Name *")).'
        </p>
        <p class="field">'.HTMLHelper::genererInputCheckBox('active', '1', $this->get_active(), array('label_position' => 'right'), "Active" ).'</p>
        <p class="field">'.(is_array($this->get_api_key())?
          HTMLHelper::genererTextArea( "api_key", parameters_to_string( $this->get_api_key() ), array(), "Api Key *" ):
          HTMLHelper::genererInputText( "api_key", $this->get_api_key(), array(), "Api Key *")).'
        </p>
        <p class="field">'.(is_array($this->get_created())?
          HTMLHelper::genererTextArea( "created", parameters_to_string( $this->get_created() ), array(), "Created *" ):
          HTMLHelper::genererInputText( "created", $this->get_created(), array(), "Created *")).'
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
      case 1 : $return = "Le champ <strong>Member Id</strong> est obligatoire."; break;
      case 2 : $return = "Le champ <strong>Name</strong> est obligatoire."; break;
      case 3 : $return = "Le champ <strong>Api Key</strong> est obligatoire."; break;
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

    $return[] = Member::check_compulsory($this->get_member_id(), 1, true);
    $return[] = Member::check_compulsory($this->get_name(), 2);
    $return[] = Member::check_compulsory($this->get_api_key(), 3);
    $return[] = Member::check_compulsory($this->get_created(), 4);

    $return = array_unique($return);
    if(($true_key = array_search(true, $return, true)) !== false) {
      unset($return[$true_key]);
    }
    if(count($return) == 0) $return = true;
    return $return;
  }

  public function get_message_recipient_list($message_id = null) {
    $where = '';
    if( ! is_null( $message_id )) $where .= '
AND `message_id` = '.mysql_ureal_escape_string($message_id);

    $sql = '
SELECT `message_id`, `player_id`, `read`
FROM `message_recipient`
WHERE `player_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_message_recipient( $message_id, $read = null ) {
    $sql = "REPLACE INTO `message_recipient` ( `message_id`, `player_id`, `read` ) VALUES (".mysql_ureal_escape_string( $message_id, $this->get_id(), guess_time( $read, GUESS_TIME_MYSQL ) ).")";

    return mysql_uquery($sql);
  }

  public function del_message_recipient( $message_id = null ) {
    $where = '';
    if( ! is_null( $message_id )) $where .= '
AND `message_id` = '.mysql_ureal_escape_string($message_id);
    $sql = 'DELETE FROM `message_recipient`
    WHERE `player_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_player_skill_list($skill_id = null) {
    $where = '';
    if( ! is_null( $skill_id )) $where .= '
AND `skill_id` = '.mysql_ureal_escape_string($skill_id);

    $sql = '
SELECT `player_id`, `skill_id`, `experience`
FROM `player_skill`
WHERE `player_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_player_skill( $skill_id, $experience ) {
    $sql = "REPLACE INTO `player_skill` ( `player_id`, `skill_id`, `experience` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $skill_id, $experience ).")";

    return mysql_uquery($sql);
  }

  public function del_player_skill( $skill_id = null ) {
    $where = '';
    if( ! is_null( $skill_id )) $where .= '
AND `skill_id` = '.mysql_ureal_escape_string($skill_id);
    $sql = 'DELETE FROM `player_skill`
    WHERE `player_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }







  // CUSTOM

  //Custom content

  // /CUSTOM

}