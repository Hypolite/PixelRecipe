<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['action'])) {
      if(isset($_POST['blueprint_id']) && is_array($_POST['blueprint_id'])) {
        foreach($_POST['blueprint_id'] as $blueprint_id) {

          $blueprint = Blueprint::instance( $blueprint_id );
          switch($_POST['action']) {
            case 'delete' :
              $blueprint->db_delete();
              break;
          }
        }
      }
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM