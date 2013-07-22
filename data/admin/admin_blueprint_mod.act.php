<?php

  if(isset($_POST['blueprint_submit'])) {
    unset($_POST['blueprint_submit']);

    $blueprint_mod = Blueprint::instance( getValue('id') );

    $blueprint_mod->load_from_html_form($_POST, $_FILES);
    $tab_error = $blueprint_mod->check_valid();

    if($tab_error === true) {
      $blueprint_mod->save();

      Page::set_message( 'Record successfuly saved' );
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM