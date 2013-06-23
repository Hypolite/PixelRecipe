<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['action'])) {
      if(isset($_POST['item_type_id']) && is_array($_POST['item_type_id'])) {
        foreach($_POST['item_type_id'] as $item_type_id) {

          $item_type = Item_Type::instance( $item_type_id );
          switch($_POST['action']) {
            case 'delete' :
              $item_type->db_delete();
              break;
          }
        }
      }
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM