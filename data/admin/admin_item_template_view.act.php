<?php
  $item_template = Item_Template::instance( getValue('id') );

  if(!is_null(getValue('action'))) {
    switch( getValue('action') ) {
       case 'set_blueprint_byproduct':
        if( $item_template->id ) {
          $flag_set_blueprint_byproduct = $item_template->set_blueprint_byproduct(
            ($value = getValue('blueprint_id')) == ''?null:$value,
            ($value = getValue('quantity')) == ''?null:$value
          );
          if( ! $flag_set_blueprint_byproduct ) {
            Page::add_message( '$item_template->set_blueprint_byproduct : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_blueprint_byproduct':
        if( $item_template->id ) {
          $flag_del_blueprint_byproduct = $item_template->del_blueprint_byproduct(
            ($value = getValue('blueprint_id')) == ''?null:$value
          );
        }
        break;
      case 'set_blueprint_consumable':
        if( $item_template->id ) {
          $flag_set_blueprint_consumable = $item_template->set_blueprint_consumable(
            ($value = getValue('blueprint_id')) == ''?null:$value,
            ($value = getValue('quantity')) == ''?null:$value
          );
          if( ! $flag_set_blueprint_consumable ) {
            Page::add_message( '$item_template->set_blueprint_consumable : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_blueprint_consumable':
        if( $item_template->id ) {
          $flag_del_blueprint_consumable = $item_template->del_blueprint_consumable(
            ($value = getValue('blueprint_id')) == ''?null:$value
          );
        }
        break;
      case 'set_item_template_ability':
        if( $item_template->id ) {
          $flag_set_item_template_ability = $item_template->set_item_template_ability(
            ($value = getValue('ability_id')) == ''?null:$value,
            ($value = getValue('points_provided')) == ''?null:$value
          );
          if( ! $flag_set_item_template_ability ) {
            Page::add_message( '$item_template->set_item_template_ability : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_item_template_ability':
        if( $item_template->id ) {
          $flag_del_item_template_ability = $item_template->del_item_template_ability(
            ($value = getValue('ability_id')) == ''?null:$value
          );
        }
        break;
      default:
        break;
    }
  }

  // CUSTOM

  //Custom content

  // /CUSTOM
