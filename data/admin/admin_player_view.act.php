<?php
  $player = Player::instance( getValue('id') );

  if(!is_null(getValue('action'))) {
    switch( getValue('action') ) {
       case 'set_message_recipient':
        if( $player->id ) {
          $flag_set_message_recipient = $player->set_message_recipient(
            ($value = getValue('message_id')) == ''?null:$value,
            ($value = getValue('read')) == ''?null:$value
          );
          if( ! $flag_set_message_recipient ) {
            Page::add_message( '$player->set_message_recipient : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_message_recipient':
        if( $player->id ) {
          $flag_del_message_recipient = $player->del_message_recipient(
            ($value = getValue('message_id')) == ''?null:$value
          );
        }
        break;
      case 'set_player_skill':
        if( $player->id ) {
          $flag_set_player_skill = $player->set_player_skill(
            ($value = getValue('skill_id')) == ''?null:$value,
            ($value = getValue('experience')) == ''?null:$value
          );
          if( ! $flag_set_player_skill ) {
            Page::add_message( '$player->set_player_skill : ' . mysql_error(), Page::PAGE_MESSAGE_ERROR );
          }
        }
        break;
      case 'del_player_skill':
        if( $player->id ) {
          $flag_del_player_skill = $player->del_player_skill(
            ($value = getValue('skill_id')) == ''?null:$value
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
