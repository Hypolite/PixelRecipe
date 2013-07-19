<?php
  $skill = Skill::instance( getValue('id') );

  if(!is_null(getValue('action'))) {
    switch( getValue('action') ) {
       case 'set_player_skill':
        if( $skill->id ) {
          $flag_set_player_skill = $skill->set_player_skill(
            ($value = getValue('player_id')) == ''?null:$value,
            ($value = getValue('experience')) == ''?null:$value
          );
          if( ! $flag_set_player_skill ) {
            Page::add_message( '$skill->set_player_skill : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_player_skill':
        if( $skill->id ) {
          $flag_del_player_skill = $skill->del_player_skill(
            ($value = getValue('player_id')) == ''?null:$value
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
