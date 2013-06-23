<?php
  $member = Member::get_current_user();

  if( getValue('player_id') ) {
    $player = Player::instance(getValue('player_id'));
    if( $player->member_id == $member->id ) {
      Page::set_message(__('You are now playing as %s', $player->name), Page::PAGE_MESSAGE_NOTICE);
      Player::set_current( $player );
    }
  }

  $redirect_page = false;

  $current_player = Player::get_current( $member );

  if( !$current_player ) {
    // No player created
    $redirect_page = 'create_player';
  }

  if( $redirect_page ) {
    Page::redirect($redirect_page);
  }
?>