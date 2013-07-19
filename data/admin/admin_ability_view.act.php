<?php
  $ability = Ability::instance( getValue('id') );

  if(!is_null(getValue('action'))) {
    switch( getValue('action') ) {
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
      case 'set_recipe_ability':
        if( $ability->id ) {
          $flag_set_recipe_ability = $ability->set_recipe_ability(
            ($value = getValue('recipe_id')) == ''?null:$value,
            ($value = getValue('points_needed')) == ''?null:$value
          );
          if( ! $flag_set_recipe_ability ) {
            Page::add_message( '$ability->set_recipe_ability : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_recipe_ability':
        if( $ability->id ) {
          $flag_del_recipe_ability = $ability->del_recipe_ability(
            ($value = getValue('recipe_id')) == ''?null:$value
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
