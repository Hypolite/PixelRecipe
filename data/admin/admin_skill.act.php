<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['action'])) {
      if(isset($_POST['skill_id']) && is_array($_POST['skill_id'])) {
        foreach($_POST['skill_id'] as $skill_id) {

          $skill = Skill::instance( $skill_id );
          switch($_POST['action']) {
            case 'delete' :
              $skill->db_delete();
              break;
          }
        }
      }
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM