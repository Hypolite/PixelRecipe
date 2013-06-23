<?php

  if(isset($_POST['item_template_submit'])) {
    unset($_POST['item_template_submit']);

    $item_template_mod = Item_Template::instance( getValue('id') );

    $item_template_mod->load_from_html_form($_POST, $_FILES);
    $tab_error = $item_template_mod->check_valid();

    if($tab_error === true) {
      $item_template_mod->save();

      Page::set_message( 'Record successfuly saved' );
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM