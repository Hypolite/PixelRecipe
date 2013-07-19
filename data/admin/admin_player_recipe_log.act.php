<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['action'])) {
      if(isset($_POST['player_recipe_log_id']) && is_array($_POST['player_recipe_log_id'])) {
        foreach($_POST['player_recipe_log_id'] as $player_recipe_log_id) {

          $player_recipe_log = Player_Recipe_Log::instance( $player_recipe_log_id );
          switch($_POST['action']) {
            case 'delete' :
              $player_recipe_log->db_delete();
              break;
          }
        }
      }
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM