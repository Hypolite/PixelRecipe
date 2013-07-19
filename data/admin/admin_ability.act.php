<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['action'])) {
      if(isset($_POST['ability_id']) && is_array($_POST['ability_id'])) {
        foreach($_POST['ability_id'] as $ability_id) {

          $ability = Ability::instance( $ability_id );
          switch($_POST['action']) {
            case 'delete' :
              $ability->db_delete();
              break;
          }
        }
      }
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM