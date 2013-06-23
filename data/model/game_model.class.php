<?php
/**
 * Classe Game
 *
 */

class Game_Model extends DBObject {
  // Champs BD
  protected $_name = null;
  protected $_version = null;
  protected $_world_id = null;
  protected $_current_turn = null;
  protected $_turn_interval = null;
  protected $_turn_limit = null;
  protected $_min_players = null;
  protected $_max_players = null;
  protected $_parameters = null;
  protected $_created = null;
  protected $_started = null;
  protected $_updated = null;
  protected $_ended = null;
  protected $_created_by = null;

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "game"; }

  public function get_created()    { return guess_time($this->_created);}
  public function get_started()    { return guess_time($this->_started);}
  public function get_updated()    { return guess_time($this->_updated);}
  public function get_ended()    { return guess_time($this->_ended);}

  /* MUTATEURS */
  public function set_id($id) {
    if( is_numeric($id) && (int)$id == $id) $data = intval($id); else $data = null; $this->_id = $data;
  }
  public function set_world_id($world_id) {
    if( is_numeric($world_id) && (int)$world_id == $world_id) $data = intval($world_id); else $data = null; $this->_world_id = $data;
  }
  public function set_current_turn($current_turn) {
    if( is_numeric($current_turn) && (int)$current_turn == $current_turn) $data = intval($current_turn); else $data = null; $this->_current_turn = $data;
  }
  public function set_turn_interval($turn_interval) {
    if( is_numeric($turn_interval) && (int)$turn_interval == $turn_interval) $data = intval($turn_interval); else $data = null; $this->_turn_interval = $data;
  }
  public function set_turn_limit($turn_limit) {
    if( is_numeric($turn_limit) && (int)$turn_limit == $turn_limit) $data = intval($turn_limit); else $data = null; $this->_turn_limit = $data;
  }
  public function set_min_players($min_players) {
    if( is_numeric($min_players) && (int)$min_players == $min_players) $data = intval($min_players); else $data = null; $this->_min_players = $data;
  }
  public function set_max_players($max_players) {
    if( is_numeric($max_players) && (int)$max_players == $max_players) $data = intval($max_players); else $data = null; $this->_max_players = $data;
  }
  public function set_created($date) { $this->_created = guess_time($date, GUESS_DATE_MYSQL);}
  public function set_started($date) { $this->_started = guess_time($date, GUESS_DATE_MYSQL);}
  public function set_updated($date) { $this->_updated = guess_time($date, GUESS_DATE_MYSQL);}
  public function set_ended($date) { $this->_ended = guess_time($date, GUESS_DATE_MYSQL);}
  public function set_created_by($created_by) {
    if( is_numeric($created_by) && (int)$created_by == $created_by) $data = intval($created_by); else $data = null; $this->_created_by = $data;
  }

  /* FONCTIONS SQL */


  public static function db_get_by_world_id($world_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `world_id` = ".mysql_ureal_escape_string($world_id);

    return self::sql_to_list($sql);
  }
  public static function db_get_by_created_by($created_by) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `created_by` = ".mysql_ureal_escape_string($created_by);

    return self::sql_to_list($sql);
  }

  public static function db_get_select_list( $with_null = false ) {
    $return = array();

    if( $with_null ) {
        $return[ null ] = 'N/A';
    }

    $object_list = Game_Model::db_get_all();
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
        <p class="field">'.(is_array($this->get_version())?
          HTMLHelper::genererTextArea( "version", parameters_to_string( $this->get_version() ), array(), "Version" ):
          HTMLHelper::genererInputText( "version", $this->get_version(), array(), "Version")).'
        </p>';
      $option_list = array();
      $world_list = World::db_get_all();
      foreach( $world_list as $world)
        $option_list[ $world->id ] = $world->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('world_id', $option_list, $this->get_world_id(), array(), "World Id *").'<a href="'.get_page_url('admin_world_mod').'">Créer un objet World</a></p>
        <p class="field">'.(is_array($this->get_current_turn())?
          HTMLHelper::genererTextArea( "current_turn", parameters_to_string( $this->get_current_turn() ), array(), "Current Turn" ):
          HTMLHelper::genererInputText( "current_turn", $this->get_current_turn(), array(), "Current Turn")).'
        </p>
        <p class="field">'.(is_array($this->get_turn_interval())?
          HTMLHelper::genererTextArea( "turn_interval", parameters_to_string( $this->get_turn_interval() ), array(), "Turn Interval *" ):
          HTMLHelper::genererInputText( "turn_interval", $this->get_turn_interval(), array(), "Turn Interval *")).'
        </p>
        <p class="field">'.(is_array($this->get_turn_limit())?
          HTMLHelper::genererTextArea( "turn_limit", parameters_to_string( $this->get_turn_limit() ), array(), "Turn Limit *" ):
          HTMLHelper::genererInputText( "turn_limit", $this->get_turn_limit(), array(), "Turn Limit *")).'
        </p>
        <p class="field">'.(is_array($this->get_min_players())?
          HTMLHelper::genererTextArea( "min_players", parameters_to_string( $this->get_min_players() ), array(), "Min Players" ):
          HTMLHelper::genererInputText( "min_players", $this->get_min_players(), array(), "Min Players")).'
        </p>
        <p class="field">'.(is_array($this->get_max_players())?
          HTMLHelper::genererTextArea( "max_players", parameters_to_string( $this->get_max_players() ), array(), "Max Players" ):
          HTMLHelper::genererInputText( "max_players", $this->get_max_players(), array(), "Max Players")).'
        </p>
        <p class="field">'.(is_array($this->get_parameters())?
          HTMLHelper::genererTextArea( "parameters", parameters_to_string( $this->get_parameters() ), array(), "Parameters" ):
          HTMLHelper::genererInputText( "parameters", $this->get_parameters(), array(), "Parameters")).'
        </p>
        <p class="field">'.(is_array($this->get_created())?
          HTMLHelper::genererTextArea( "created", parameters_to_string( $this->get_created() ), array(), "Created *" ):
          HTMLHelper::genererInputText( "created", $this->get_created(), array(), "Created *")).'
        </p>
        <p class="field">'.(is_array($this->get_started())?
          HTMLHelper::genererTextArea( "started", parameters_to_string( $this->get_started() ), array(), "Started" ):
          HTMLHelper::genererInputText( "started", $this->get_started(), array(), "Started")).'
        </p>
        <p class="field">'.(is_array($this->get_updated())?
          HTMLHelper::genererTextArea( "updated", parameters_to_string( $this->get_updated() ), array(), "Updated" ):
          HTMLHelper::genererInputText( "updated", $this->get_updated(), array(), "Updated")).'
        </p>
        <p class="field">'.(is_array($this->get_ended())?
          HTMLHelper::genererTextArea( "ended", parameters_to_string( $this->get_ended() ), array(), "Ended" ):
          HTMLHelper::genererInputText( "ended", $this->get_ended(), array(), "Ended")).'
        </p>';
      $option_list = array();
      $player_list = Player::db_get_all();
      foreach( $player_list as $player)
        $option_list[ $player->id ] = $player->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('created_by', $option_list, $this->get_created_by(), array(), "Created By *").'<a href="'.get_page_url('admin_player_mod').'">Créer un objet Player</a></p>

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
      case 2 : $return = "Le champ <strong>World Id</strong> est obligatoire."; break;
      case 3 : $return = "Le champ <strong>Turn Interval</strong> est obligatoire."; break;
      case 4 : $return = "Le champ <strong>Turn Limit</strong> est obligatoire."; break;
      case 5 : $return = "Le champ <strong>Created</strong> est obligatoire."; break;
      case 6 : $return = "Le champ <strong>Created By</strong> est obligatoire."; break;
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
    $return[] = Member::check_compulsory($this->get_world_id(), 2, true);
    $return[] = Member::check_compulsory($this->get_turn_interval(), 3, true);
    $return[] = Member::check_compulsory($this->get_turn_limit(), 4, true);
    $return[] = Member::check_compulsory($this->get_created(), 5);
    $return[] = Member::check_compulsory($this->get_created_by(), 6, true);

    $return = array_unique($return);
    if(($true_key = array_search(true, $return, true)) !== false) {
      unset($return[$true_key]);
    }
    if(count($return) == 0) $return = true;
    return $return;
  }

  public function get_game_player_list($player_id = null) {
    $where = '';
    if( ! is_null( $player_id )) $where .= '
AND `player_id` = '.mysql_ureal_escape_string($player_id);

    $sql = '
SELECT `game_id`, `player_id`, `turn_ready`, `turn_leave`
FROM `game_player`
WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_game_player( $player_id, $turn_ready, $turn_leave = null ) {
    $sql = "REPLACE INTO `game_player` ( `game_id`, `player_id`, `turn_ready`, `turn_leave` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $player_id, $turn_ready, $turn_leave ).")";

    return mysql_uquery($sql);
  }

  public function del_game_player( $player_id = null ) {
    $where = '';
    if( ! is_null( $player_id )) $where .= '
AND `player_id` = '.mysql_ureal_escape_string($player_id);
    $sql = 'DELETE FROM `game_player`
    WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_player_diplomacy_list($turn = null, $from_player_id = null, $to_player_id = null) {
    $where = '';
    if( ! is_null( $turn )) $where .= '
AND `turn` = '.mysql_ureal_escape_string($turn);
    if( ! is_null( $from_player_id )) $where .= '
AND `from_player_id` = '.mysql_ureal_escape_string($from_player_id);
    if( ! is_null( $to_player_id )) $where .= '
AND `to_player_id` = '.mysql_ureal_escape_string($to_player_id);

    $sql = '
SELECT `game_id`, `turn`, `from_player_id`, `to_player_id`, `status`
FROM `player_diplomacy`
WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_player_diplomacy( $turn, $from_player_id, $to_player_id, $status ) {
    $sql = "REPLACE INTO `player_diplomacy` ( `game_id`, `turn`, `from_player_id`, `to_player_id`, `status` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $turn, $from_player_id, $to_player_id, $status ).")";

    return mysql_uquery($sql);
  }

  public function del_player_diplomacy( $turn = null, $from_player_id = null, $to_player_id = null ) {
    $where = '';
    if( ! is_null( $turn )) $where .= '
AND `turn` = '.mysql_ureal_escape_string($turn);
    if( ! is_null( $from_player_id )) $where .= '
AND `from_player_id` = '.mysql_ureal_escape_string($from_player_id);
    if( ! is_null( $to_player_id )) $where .= '
AND `to_player_id` = '.mysql_ureal_escape_string($to_player_id);
    $sql = 'DELETE FROM `player_diplomacy`
    WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_player_history_list($player_id = null, $territory_id = null) {
    $where = '';
    if( ! is_null( $player_id )) $where .= '
AND `player_id` = '.mysql_ureal_escape_string($player_id);
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);

    $sql = '
SELECT `game_id`, `player_id`, `turn`, `datetime`, `reason`, `territory_id`
FROM `player_history`
WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_player_history( $player_id, $turn, $datetime, $reason, $territory_id = null ) {
    $sql = "REPLACE INTO `player_history` ( `game_id`, `player_id`, `turn`, `datetime`, `reason`, `territory_id` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $player_id, $turn, guess_time( $datetime, GUESS_TIME_MYSQL ), $reason, $territory_id ).")";

    return mysql_uquery($sql);
  }

  public function del_player_history( $player_id = null, $territory_id = null ) {
    $where = '';
    if( ! is_null( $player_id )) $where .= '
AND `player_id` = '.mysql_ureal_escape_string($player_id);
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);
    $sql = 'DELETE FROM `player_history`
    WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_territory_economy_history_list($territory_id = null) {
    $where = '';
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);

    $sql = '
SELECT `territory_id`, `game_id`, `turn`, `delta`, `reason`
FROM `territory_economy_history`
WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_territory_economy_history( $territory_id, $turn, $delta, $reason ) {
    $sql = "REPLACE INTO `territory_economy_history` ( `territory_id`, `game_id`, `turn`, `delta`, `reason` ) VALUES (".mysql_ureal_escape_string( $territory_id, $this->get_id(), $turn, $delta, $reason ).")";

    return mysql_uquery($sql);
  }

  public function del_territory_economy_history( $territory_id = null ) {
    $where = '';
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);
    $sql = 'DELETE FROM `territory_economy_history`
    WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_territory_player_status_list($turn = null, $territory_id = null, $player_id = null) {
    $where = '';
    if( ! is_null( $turn )) $where .= '
AND `turn` = '.mysql_ureal_escape_string($turn);
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);
    if( ! is_null( $player_id )) $where .= '
AND `player_id` = '.mysql_ureal_escape_string($player_id);

    $sql = '
SELECT `game_id`, `turn`, `territory_id`, `player_id`, `supremacy`
FROM `territory_player_status`
WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_territory_player_status( $turn, $territory_id, $player_id, $supremacy ) {
    $sql = "REPLACE INTO `territory_player_status` ( `game_id`, `turn`, `territory_id`, `player_id`, `supremacy` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $turn, $territory_id, $player_id, $supremacy ).")";

    return mysql_uquery($sql);
  }

  public function del_territory_player_status( $turn = null, $territory_id = null, $player_id = null ) {
    $where = '';
    if( ! is_null( $turn )) $where .= '
AND `turn` = '.mysql_ureal_escape_string($turn);
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);
    if( ! is_null( $player_id )) $where .= '
AND `player_id` = '.mysql_ureal_escape_string($player_id);
    $sql = 'DELETE FROM `territory_player_status`
    WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_territory_player_troops_history_list($turn = null, $territory_id = null, $player_id = null, $reason_player_id = null) {
    $where = '';
    if( ! is_null( $turn )) $where .= '
AND `turn` = '.mysql_ureal_escape_string($turn);
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);
    if( ! is_null( $player_id )) $where .= '
AND `player_id` = '.mysql_ureal_escape_string($player_id);
    if( ! is_null( $reason_player_id )) $where .= '
AND `reason_player_id` = '.mysql_ureal_escape_string($reason_player_id);

    $sql = '
SELECT `game_id`, `turn`, `territory_id`, `player_id`, `delta`, `reason`, `reason_player_id`
FROM `territory_player_troops_history`
WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_territory_player_troops_history( $turn, $territory_id, $player_id, $delta, $reason, $reason_player_id = null ) {
    $sql = "REPLACE INTO `territory_player_troops_history` ( `game_id`, `turn`, `territory_id`, `player_id`, `delta`, `reason`, `reason_player_id` ) VALUES (".mysql_ureal_escape_string( $this->get_id(), $turn, $territory_id, $player_id, $delta, $reason, $reason_player_id ).")";

    return mysql_uquery($sql);
  }

  public function del_territory_player_troops_history( $turn = null, $territory_id = null, $player_id = null, $reason_player_id = null ) {
    $where = '';
    if( ! is_null( $turn )) $where .= '
AND `turn` = '.mysql_ureal_escape_string($turn);
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);
    if( ! is_null( $player_id )) $where .= '
AND `player_id` = '.mysql_ureal_escape_string($player_id);
    if( ! is_null( $reason_player_id )) $where .= '
AND `reason_player_id` = '.mysql_ureal_escape_string($reason_player_id);
    $sql = 'DELETE FROM `territory_player_troops_history`
    WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }



  public function get_territory_status_list($territory_id = null, $turn = null, $owner_id = null) {
    $where = '';
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);
    if( ! is_null( $turn )) $where .= '
AND `turn` = '.mysql_ureal_escape_string($turn);
    if( ! is_null( $owner_id )) $where .= '
AND `owner_id` = '.mysql_ureal_escape_string($owner_id);

    $sql = '
SELECT `territory_id`, `game_id`, `turn`, `owner_id`, `contested`, `conflict`, `capital`, `revenue_suppression`
FROM `territory_status`
WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;
    $res = mysql_uquery($sql);

    return mysql_fetch_to_array($res);
  }

  public function set_territory_status( $territory_id, $turn, $owner_id = null, $contested, $conflict, $capital, $revenue_suppression ) {
    $sql = "REPLACE INTO `territory_status` ( `territory_id`, `game_id`, `turn`, `owner_id`, `contested`, `conflict`, `capital`, `revenue_suppression` ) VALUES (".mysql_ureal_escape_string( $territory_id, $this->get_id(), $turn, $owner_id, $contested, $conflict, $capital, $revenue_suppression ).")";

    return mysql_uquery($sql);
  }

  public function del_territory_status( $territory_id = null, $turn = null, $owner_id = null ) {
    $where = '';
    if( ! is_null( $territory_id )) $where .= '
AND `territory_id` = '.mysql_ureal_escape_string($territory_id);
    if( ! is_null( $turn )) $where .= '
AND `turn` = '.mysql_ureal_escape_string($turn);
    if( ! is_null( $owner_id )) $where .= '
AND `owner_id` = '.mysql_ureal_escape_string($owner_id);
    $sql = 'DELETE FROM `territory_status`
    WHERE `game_id` = '.mysql_ureal_escape_string($this->get_id()).$where;

    return mysql_uquery($sql);
  }







  // CUSTOM

  //Custom content

  // /CUSTOM

}