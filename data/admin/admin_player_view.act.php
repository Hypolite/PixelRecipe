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
      default:
        break;
    }
  }
  
  // CUSTOM

  //Custom content

  // /CUSTOM
