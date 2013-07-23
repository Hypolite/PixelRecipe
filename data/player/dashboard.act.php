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

	// Sleep
	$sleep_gain = $current_player->sleep();
	if( $sleep_gain > 0 ) {
		Page::add_message('You slept during '.$sleep_gain.' cycles for '.$sleep_gain.' Energy.');
	}

	$current_player->last_active = time();
	$current_player->save();
?>