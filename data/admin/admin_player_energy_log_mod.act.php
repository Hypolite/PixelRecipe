<?php

  if(isset($_POST['player_energy_log_submit'])) {
    unset($_POST['player_energy_log_submit']);

    $player_energy_log_mod = Player_Energy_Log::instance( getValue('id') );

    $player_energy_log_mod->load_from_html_form($_POST, $_FILES);
    $tab_error = $player_energy_log_mod->check_valid();

    if($tab_error === true) {
      $player_energy_log_mod->save();

      Page::set_message( 'Record successfuly saved' );
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM