<?php

  if(isset($_POST['item_type_submit'])) {
    unset($_POST['item_type_submit']);

    $item_type_mod = Item_Type::instance( getValue('id') );

    $item_type_mod->load_from_html_form($_POST, $_FILES);
    $tab_error = $item_type_mod->check_valid();

    if($tab_error === true) {
      $item_type_mod->save();

      Page::set_message( 'Record successfuly saved' );
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM