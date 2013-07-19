<?php
/**
 * Classe Player_Recipe_Log
 *
 */

class Player_Recipe_Log_Model extends DBObject {
  // Champs BD
  protected $_player_id = null;
  protected $_recipe_id = null;
  protected $_time_taken = null;
  protected $_timestamp = null;

  public function __construct($id = null) {
    parent::__construct($id);
  }

  /* ACCESSEURS */
  public static function get_table_name() { return "player_recipe_log"; }

  public function get_timestamp()    { return guess_time($this->_timestamp);}

  /* MUTATEURS */
  public function set_player_id($player_id) {
    if( is_numeric($player_id) && (int)$player_id == $player_id) $data = intval($player_id); else $data = null; $this->_player_id = $data;
  }
  public function set_time_taken($time_taken) {
    if( is_numeric($time_taken) && (int)$time_taken == $time_taken) $data = intval($time_taken); else $data = null; $this->_time_taken = $data;
  }
  public function set_timestamp($date) { $this->_timestamp = guess_time($date, GUESS_DATE_MYSQL);}

  /* FONCTIONS SQL */


  public static function db_get_by_player_id($player_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `player_id` = ".mysql_ureal_escape_string($player_id);

    return self::sql_to_list($sql);
  }
  public static function db_get_by_recipe_id($recipe_id) {
    $sql = "
SELECT `id` FROM `".self::get_table_name()."`
WHERE `recipe_id` = ".mysql_ureal_escape_string($recipe_id);

    return self::sql_to_list($sql);
  }

  public static function db_get_select_list( $with_null = false ) {
    $return = array();

    if( $with_null ) {
        $return[ null ] = 'N/A';
    }

    $object_list = Player_Recipe_Log_Model::db_get_all();
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
      <p class="field">'.HTMLHelper::genererSelect('player_id', $option_list, $this->get_player_id(), array(), "Player Id *").'<a href="'.get_page_url('admin_player_mod').'">Créer un objet Player</a></p>';
      $option_list = array();
      $recipe_list = Recipe::db_get_all();
      foreach( $recipe_list as $recipe)
        $option_list[ $recipe->id ] = $recipe->name;

      $return .= '
      <p class="field">'.HTMLHelper::genererSelect('recipe_id', $option_list, $this->get_recipe_id(), array(), "Recipe Id *").'<a href="'.get_page_url('admin_recipe_mod').'">Créer un objet Recipe</a></p>
        <p class="field">'.(is_array($this->get_time_taken())?
          HTMLHelper::genererTextArea( "time_taken", parameters_to_string( $this->get_time_taken() ), array(), "Time Taken *" ):
          HTMLHelper::genererInputText( "time_taken", $this->get_time_taken(), array(), "Time Taken *")).'
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
      case 2 : $return = "Le champ <strong>Recipe Id</strong> est obligatoire."; break;
      case 3 : $return = "Le champ <strong>Time Taken</strong> est obligatoire."; break;
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
    $return[] = Member::check_compulsory($this->get_recipe_id(), 2);
    $return[] = Member::check_compulsory($this->get_time_taken(), 3, true);
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