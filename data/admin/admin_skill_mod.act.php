<?php

  if(isset($_POST['skill_submit'])) {
    unset($_POST['skill_submit']);

    $skill_mod = Skill::instance( getValue('id') );

    $skill_mod->load_from_html_form($_POST, $_FILES);
    $tab_error = $skill_mod->check_valid();

    if($tab_error === true) {
      $skill_mod->save();

      Page::set_message( 'Record successfuly saved' );
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM