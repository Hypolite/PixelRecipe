<?php
  $item_template = Item_Template::instance( getValue('id') );

  if(!is_null(getValue('action'))) {
    switch( getValue('action') ) {
       case 'set_recipe_byproduct':
        if( $item_template->id ) {
          $flag_set_recipe_byproduct = $item_template->set_recipe_byproduct(
            ($value = getValue('recipe_id')) == ''?null:$value,
            ($value = getValue('quantity')) == ''?null:$value
          );
          if( ! $flag_set_recipe_byproduct ) {
            Page::add_message( '$item_template->set_recipe_byproduct : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_recipe_byproduct':
        if( $item_template->id ) {
          $flag_del_recipe_byproduct = $item_template->del_recipe_byproduct(
            ($value = getValue('recipe_id')) == ''?null:$value
          );
        }
        break;
      case 'set_recipe_consumable':
        if( $item_template->id ) {
          $flag_set_recipe_consumable = $item_template->set_recipe_consumable(
            ($value = getValue('recipe_id')) == ''?null:$value,
            ($value = getValue('quantity')) == ''?null:$value
          );
          if( ! $flag_set_recipe_consumable ) {
            Page::add_message( '$item_template->set_recipe_consumable : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_recipe_consumable':
        if( $item_template->id ) {
          $flag_del_recipe_consumable = $item_template->del_recipe_consumable(
            ($value = getValue('recipe_id')) == ''?null:$value
          );
        }
        break;
      case 'set_recipe_tool':
        if( $item_template->id ) {
          $flag_set_recipe_tool = $item_template->set_recipe_tool(
            ($value = getValue('recipe_id')) == ''?null:$value
          );
          if( ! $flag_set_recipe_tool ) {
            Page::add_message( '$item_template->set_recipe_tool : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_recipe_tool':
        if( $item_template->id ) {
          $flag_del_recipe_tool = $item_template->del_recipe_tool(
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
