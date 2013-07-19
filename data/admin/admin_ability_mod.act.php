<?php

  if(isset($_POST['ability_submit'])) {
    unset($_POST['ability_submit']);

    $ability_mod = Ability::instance( getValue('id') );

    $ability_mod->load_from_html_form($_POST, $_FILES);
    $tab_error = $ability_mod->check_valid();

    if($tab_error === true) {
      $ability_mod->save();

      Page::set_message( 'Record successfuly saved' );
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM