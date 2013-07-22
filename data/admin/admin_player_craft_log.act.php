<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['action'])) {
      if(isset($_POST['player_craft_log_id']) && is_array($_POST['player_craft_log_id'])) {
        foreach($_POST['player_craft_log_id'] as $player_craft_log_id) {

          $player_craft_log = Player_Craft_Log::instance( $player_craft_log_id );
          switch($_POST['action']) {
            case 'delete' :
              $player_craft_log->db_delete();
              break;
          }
        }
      }
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM