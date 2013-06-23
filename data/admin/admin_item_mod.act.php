<?php

  if(isset($_POST['item_submit'])) {
    unset($_POST['item_submit']);

    $item_mod = Item::instance( getValue('id') );

    $item_mod->load_from_html_form($_POST, $_FILES);
    $tab_error = $item_mod->check_valid();

    if($tab_error === true) {
      $item_mod->save();

      Page::set_message( 'Record successfuly saved' );
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM