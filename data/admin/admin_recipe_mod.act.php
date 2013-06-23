<?php

  if(isset($_POST['recipe_submit'])) {
    unset($_POST['recipe_submit']);

    $recipe_mod = Recipe::instance( getValue('id') );

    $recipe_mod->load_from_html_form($_POST, $_FILES);
    $tab_error = $recipe_mod->check_valid();

    if($tab_error === true) {
      $recipe_mod->save();

      Page::set_message( 'Record successfuly saved' );
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM