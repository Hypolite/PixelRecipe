<?php

  if(isset($_POST['player_craft_log_submit'])) {
    unset($_POST['player_craft_log_submit']);

    $player_craft_log_mod = Player_Craft_Log::instance( getValue('id') );

    $player_craft_log_mod->load_from_html_form($_POST, $_FILES);
    $tab_error = $player_craft_log_mod->check_valid();

    if($tab_error === true) {
      $player_craft_log_mod->save();

      Page::set_message( 'Record successfuly saved' );
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM