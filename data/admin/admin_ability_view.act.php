<?php
  $ability = Ability::instance( getValue('id') );

  if(!is_null(getValue('action'))) {
    switch( getValue('action') ) {
       case 'set_blueprint_ability':
        if( $ability->id ) {
          $flag_set_blueprint_ability = $ability->set_blueprint_ability(
            ($value = getValue('blueprint_id')) == ''?null:$value,
            ($value = getValue('points_needed')) == ''?null:$value
          );
          if( ! $flag_set_blueprint_ability ) {
            Page::add_message( '$ability->set_blueprint_ability : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_blueprint_ability':
        if( $ability->id ) {
          $flag_del_blueprint_ability = $ability->del_blueprint_ability(
            ($value = getValue('blueprint_id')) == ''?null:$value
          );
        }
        break;
      case 'set_item_template_ability':
        if( $ability->id ) {
          $flag_set_item_template_ability = $ability->set_item_template_ability(
            ($value = getValue('item_template_id')) == ''?null:$value,
            ($value = getValue('points_provided')) == ''?null:$value
          );
          if( ! $flag_set_item_template_ability ) {
            Page::add_message( '$ability->set_item_template_ability : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_item_template_ability':
        if( $ability->id ) {
          $flag_del_item_template_ability = $ability->del_item_template_ability(
            ($value = getValue('item_template_id')) == ''?null:$value
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
