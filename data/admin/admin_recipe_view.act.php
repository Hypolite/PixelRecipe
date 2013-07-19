<?php
  $recipe = Recipe::instance( getValue('id') );

  if(!is_null(getValue('action'))) {
    switch( getValue('action') ) {
       case 'set_recipe_ability':
        if( $recipe->id ) {
          $flag_set_recipe_ability = $recipe->set_recipe_ability(
            ($value = getValue('ability_id')) == ''?null:$value,
            ($value = getValue('points_needed')) == ''?null:$value
          );
          if( ! $flag_set_recipe_ability ) {
            Page::add_message( '$recipe->set_recipe_ability : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_recipe_ability':
        if( $recipe->id ) {
          $flag_del_recipe_ability = $recipe->del_recipe_ability(
            ($value = getValue('ability_id')) == ''?null:$value
          );
        }
        break;
      case 'set_recipe_byproduct':
        if( $recipe->id ) {
          $flag_set_recipe_byproduct = $recipe->set_recipe_byproduct(
            ($value = getValue('item_template_id')) == ''?null:$value,
            ($value = getValue('quantity')) == ''?null:$value
          );
          if( ! $flag_set_recipe_byproduct ) {
            Page::add_message( '$recipe->set_recipe_byproduct : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_recipe_byproduct':
        if( $recipe->id ) {
          $flag_del_recipe_byproduct = $recipe->del_recipe_byproduct(
            ($value = getValue('item_template_id')) == ''?null:$value
          );
        }
        break;
      case 'set_recipe_consumable':
        if( $recipe->id ) {
          $flag_set_recipe_consumable = $recipe->set_recipe_consumable(
            ($value = getValue('item_template_id')) == ''?null:$value,
            ($value = getValue('quantity')) == ''?null:$value
          );
          if( ! $flag_set_recipe_consumable ) {
            Page::add_message( '$recipe->set_recipe_consumable : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_recipe_consumable':
        if( $recipe->id ) {
          $flag_del_recipe_consumable = $recipe->del_recipe_consumable(
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
