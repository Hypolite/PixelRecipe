<?php
  $blueprint = Blueprint::instance( getValue('id') );

  if(!is_null(getValue('action'))) {
    switch( getValue('action') ) {
       case 'set_blueprint_ability':
        if( $blueprint->id ) {
          $flag_set_blueprint_ability = $blueprint->set_blueprint_ability(
            ($value = getValue('ability_id')) == ''?null:$value,
            ($value = getValue('points_needed')) == ''?null:$value
          );
          if( ! $flag_set_blueprint_ability ) {
            Page::add_message( '$blueprint->set_blueprint_ability : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_blueprint_ability':
        if( $blueprint->id ) {
          $flag_del_blueprint_ability = $blueprint->del_blueprint_ability(
            ($value = getValue('ability_id')) == ''?null:$value
          );
        }
        break;
      case 'set_blueprint_byproduct':
        if( $blueprint->id ) {
          $flag_set_blueprint_byproduct = $blueprint->set_blueprint_byproduct(
            ($value = getValue('item_template_id')) == ''?null:$value,
            ($value = getValue('quantity')) == ''?null:$value
          );
          if( ! $flag_set_blueprint_byproduct ) {
            Page::add_message( '$blueprint->set_blueprint_byproduct : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_blueprint_byproduct':
        if( $blueprint->id ) {
          $flag_del_blueprint_byproduct = $blueprint->del_blueprint_byproduct(
            ($value = getValue('item_template_id')) == ''?null:$value
          );
        }
        break;
      case 'set_blueprint_consumable':
        if( $blueprint->id ) {
          $flag_set_blueprint_consumable = $blueprint->set_blueprint_consumable(
            ($value = getValue('item_template_id')) == ''?null:$value,
            ($value = getValue('quantity')) == ''?null:$value
          );
          if( ! $flag_set_blueprint_consumable ) {
            Page::add_message( '$blueprint->set_blueprint_consumable : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_blueprint_consumable':
        if( $blueprint->id ) {
          $flag_del_blueprint_consumable = $blueprint->del_blueprint_consumable(
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
