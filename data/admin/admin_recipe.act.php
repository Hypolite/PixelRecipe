<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['action'])) {
      if(isset($_POST['recipe_id']) && is_array($_POST['recipe_id'])) {
        foreach($_POST['recipe_id'] as $recipe_id) {

          $recipe = Recipe::instance( $recipe_id );
          switch($_POST['action']) {
            case 'delete' :
              $recipe->db_delete();
              break;
          }
        }
      }
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM