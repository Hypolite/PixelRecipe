<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['action'])) {
      if(isset($_POST['item_id']) && is_array($_POST['item_id'])) {
        foreach($_POST['item_id'] as $item_id) {

          $item = Item::instance( $item_id );
          switch($_POST['action']) {
            case 'delete' :
              $item->db_delete();
              break;
          }
        }
      }
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM