<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['action'])) {
      if(isset($_POST['item_template_id']) && is_array($_POST['item_template_id'])) {
        foreach($_POST['item_template_id'] as $item_template_id) {

          $item_template = Item_Template::instance( $item_template_id );
          switch($_POST['action']) {
            case 'delete' :
              $item_template->db_delete();
              break;
          }
        }
      }
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM