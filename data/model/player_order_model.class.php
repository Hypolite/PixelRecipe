<?php
/**
 * Classe Player_Order
 *
 */

class Player_Order_Model extends DBObject {
  // Champs BD
  protected $_game_id = null;
  protected $_order_type_id = null;
  protected $_player_id = null;
  protected $_datetime_order = null;
  protected $_datetime_execution = null;
  protected $_turn_ordered = null;
  protected $_turn_scheduled = null;
  protected $_turn_executed = null;
  protected $_parameters = null;
  protected $_return = null;
  protected $_parent_player_order_id = null;

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "player_order"; }

  public function get_datetime_order()    { return guess_time($this->_datetime_order);}
  public function get_datetime_execution()    { return guess_time($this->_datetime_execution);}

  /* MUTATEURS */
  public function set_id($id) {
    if( is_numeric($id) && (int)$id == $id) $data = intval($id); else $data = null; $this->_id = $data;
  }
  public function set_game_id($game_id) {
    if( is_numeric($game_id) && (int)$game_id == $game_id) $data = intval($game_id); else $data = null; $this->_game_id = $data;
  }
  public function set_order_type_id($order_type_id) {
    if( is_numeric($order_type_id) && (int)$order_type_id == $order_type_id) $data = intval($order_type_id); else $data = null; $this->_order_type_id = $data;
  }
  public function set_player_id($player_id) {
    if( is_numeric($player_id) && (int)$player_id == $player_id) $data = intval($player_id); else $data = null; $this->_player_id = $data;
  }
  public function set_datetime_order($date) { $this->_datetime_order = guess_time($date, GUESS_DATE_MYSQL);}
  public function set_datetime_execution($date) { $this->_datetime_execution = guess_time($date, GUESS_DATE_MYSQL);}
  public function set_turn_ordered($turn_ordered) {
    if( is_numeric($turn_ordered) && (int)$turn_ordered == $turn_ordered) $data = intval($turn_ordered); else $data = null; $this->_turn_ordered = $data;
  }
  public function set_turn_scheduled($turn_scheduled) {
    if( is_numeric($turn_scheduled) && (int)$turn_scheduled == $turn_scheduled) $data = intval($turn_scheduled); else $data = null; $this->_turn_scheduled = $data;
  }
  public function set_turn_executed($turn_executed) {
    if( is_numeric($turn_executed) && (int)$turn_executed == $turn_executed) $data = intval($turn_executed); else $data = null; $this->_turn_executed = $data;
  }
  public function set_return($return) {
    if( is_numeric($return) && (int)$return == $return) $data = intval($return); else $data = null; $this->_return = $data;
  }
  public function set_parent_player_order_id($parent_player_order_id) {
    if( is_numeric($parent_player_order_id) && (int)$parent_player_order_id == $parent_player_order_id) $data = intval($parent_player_order_id); else $data = null; $this->_parent_player_order_id = $data;
  }

  /* FONCTIONS SQL */


  public static function db_get_by_game_id($game_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `game_id` = ".mysql_ureal_escape_string($game_id);

    return self::sql_to_list($sql);
  }
  public static function db_get_by_order_type_id($order_type_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `order_type_id` = ".mysql_ureal_escape_string($order_type_id);

    return self::sql_to_list($sql);
  }
  public static function db_get_by_player_id($player_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `player_id` = ".mysql_ureal_escape_string($player_id);

    return self::sql_to_list($sql);
  }
  public static function db_get_by_parent_player_order_id($parent_player_order_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `parent_player_order_id` = ".mysql_ureal_escape_string($parent_player_order_id);

    return self::sql_to_list($sql);
  }

  public static function db_get_select_list( $with_null = false ) {
    $return = array();

    if( $with_null ) {
        $return[ null ] = 'N/A';
    }

    $object_list = Player_Order_Model::db_get_all();
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
      $game_list = Game::db_get_all();
      foreach( $game_list as $game)
        $option_list[ $game->id ] = $game->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('game_id', $option_list, $this->get_game_id(), array(), "Game Id *").'<a href="'.get_page_url('admin_game_mod').'">Créer un objet Game</a></p>';
      $option_list = array();
      $order_type_list = Order_Type::db_get_all();
      foreach( $order_type_list as $order_type)
        $option_list[ $order_type->id ] = $order_type->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('order_type_id', $option_list, $this->get_order_type_id(), array(), "Order Type Id *").'<a href="'.get_page_url('admin_order_type_mod').'">Créer un objet Order Type</a></p>';
      $option_list = array();
      $player_list = Player::db_get_all();
      foreach( $player_list as $player)
        $option_list[ $player->id ] = $player->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('player_id', $option_list, $this->get_player_id(), array(), "Player Id *").'<a href="'.get_page_url('admin_player_mod').'">Créer un objet Player</a></p>
        <p class="field">'.(is_array($this->get_datetime_order())?
          HTMLHelper::genererTextArea( "datetime_order", parameters_to_string( $this->get_datetime_order() ), array(), "Datetime Order *" ):
          HTMLHelper::genererInputText( "datetime_order", $this->get_datetime_order(), array(), "Datetime Order *")).'
        </p>
        <p class="field">'.(is_array($this->get_datetime_execution())?
          HTMLHelper::genererTextArea( "datetime_execution", parameters_to_string( $this->get_datetime_execution() ), array(), "Datetime Execution" ):
          HTMLHelper::genererInputText( "datetime_execution", $this->get_datetime_execution(), array(), "Datetime Execution")).'
        </p>
        <p class="field">'.(is_array($this->get_turn_ordered())?
          HTMLHelper::genererTextArea( "turn_ordered", parameters_to_string( $this->get_turn_ordered() ), array(), "Turn Ordered *" ):
          HTMLHelper::genererInputText( "turn_ordered", $this->get_turn_ordered(), array(), "Turn Ordered *")).'
        </p>
        <p class="field">'.(is_array($this->get_turn_scheduled())?
          HTMLHelper::genererTextArea( "turn_scheduled", parameters_to_string( $this->get_turn_scheduled() ), array(), "Turn Scheduled *" ):
          HTMLHelper::genererInputText( "turn_scheduled", $this->get_turn_scheduled(), array(), "Turn Scheduled *")).'
        </p>
        <p class="field">'.(is_array($this->get_turn_executed())?
          HTMLHelper::genererTextArea( "turn_executed", parameters_to_string( $this->get_turn_executed() ), array(), "Turn Executed" ):
          HTMLHelper::genererInputText( "turn_executed", $this->get_turn_executed(), array(), "Turn Executed")).'
        </p>
        <p class="field">'.(is_array($this->get_parameters())?
          HTMLHelper::genererTextArea( "parameters", parameters_to_string( $this->get_parameters() ), array(), "Parameters" ):
          HTMLHelper::genererInputText( "parameters", $this->get_parameters(), array(), "Parameters")).'
        </p>
        <p class="field">'.(is_array($this->get_return())?
          HTMLHelper::genererTextArea( "return", parameters_to_string( $this->get_return() ), array(), "Return" ):
          HTMLHelper::genererInputText( "return", $this->get_return(), array(), "Return")).'
        </p>';
      $option_list = array(null => 'Pas de choix');
      $player_order_list = Player_Order::db_get_all();
      foreach( $player_order_list as $player_order)
        $option_list[ $player_order->id ] = $player_order->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('parent_player_order_id', $option_list, $this->get_parent_player_order_id(), array(), "Parent Player Order Id").'<a href="'.get_page_url('admin_player_order_mod').'">Créer un objet Player Order</a></p>

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
      case 1 : $return = "Le champ <strong>Game Id</strong> est obligatoire."; break;
      case 2 : $return = "Le champ <strong>Order Type Id</strong> est obligatoire."; break;
      case 3 : $return = "Le champ <strong>Player Id</strong> est obligatoire."; break;
      case 4 : $return = "Le champ <strong>Datetime Order</strong> est obligatoire."; break;
      case 5 : $return = "Le champ <strong>Turn Ordered</strong> est obligatoire."; break;
      case 6 : $return = "Le champ <strong>Turn Scheduled</strong> est obligatoire."; break;
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

    $return[] = Member::check_compulsory($this->get_game_id(), 1, true);
    $return[] = Member::check_compulsory($this->get_order_type_id(), 2, true);
    $return[] = Member::check_compulsory($this->get_player_id(), 3, true);
    $return[] = Member::check_compulsory($this->get_datetime_order(), 4);
    $return[] = Member::check_compulsory($this->get_turn_ordered(), 5, true);
    $return[] = Member::check_compulsory($this->get_turn_scheduled(), 6, true);

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