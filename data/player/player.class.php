<?php
/**
 * Class Player
 *
 */

require_once( DATA."model/player_model.class.php" );

class Player extends Player_Model {

  // CUSTOM
  protected $current_game = null;

  public static function db_get_by_member_id( $member_id ) {
    $sql = "
SELECT *
FROM `".self::get_table_name()."`
WHERE `member_id` = ".mysql_ureal_escape_string( $member_id );

    return self::sql_to_list( $sql );
  }

  public static function get_current( Member $member ) {
    $return = null;
    if( !isset( $_SESSION['current_player_id'] ) ) {
      $player_list = Player::db_get_by_member_id( $member->id );
      $_SESSION['current_player_id'] = null;
      if( count( $player_list ) ) {
         $player = array_shift( $player_list );
         $_SESSION['current_player_id'] = $player->id;
         $return = $player;
      }
    }else {
      $return = Player::instance( $_SESSION['current_player_id'] );
    }

    return $return;
  }

  public static function set_current( Player $player ) {
    $_SESSION['current_player_id'] = $player->id;

    return true;
  }

  public function can_create_player( Member $member ) {
    $return = is_admin();
    if( !$return ) {
      $sql = '
SELECT COUNT(*)
FROM `player`
WHERE `member_id` = '.$member->id;
      $res = mysql_uquery($sql);
      $count = array_pop( mysql_fetch_row($res) );

      $return = $count < 2;
    }
    return $return;
  }

  // /CUSTOM

}