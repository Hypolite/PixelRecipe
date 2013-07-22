<?php
	$member = Member::instance( Member::get_current_user_id() );

	$current_player = Player::get_current( $member );

	$blueprint = Blueprint::instance(getValue('blueprint_id'));

	try {
		$current_player->craft( $blueprint );
		Page::add_message('Blueprint "'.$blueprint->name.'" is crafted!');
	}catch( Exception $e ) {
		Page::add_message('Unable to craft "'.$blueprint->name.'": '.$e->getMessage(), Page::PAGE_MESSAGE_WARNING);
	}

	Page::redirect('dashboard');
?>