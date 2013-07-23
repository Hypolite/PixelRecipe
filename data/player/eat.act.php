<?php
	$member = Member::get_current_user();
	$current_player = Player::get_current( $member );
	$item_id = getValue('item_id');
	$item = Item::instance($item_id);

	try{
		$current_player->eat($item);
		Page::add_message('Item '.$item->name.' succesfully eaten');
	}catch(Exception $e) {
		$message = 'Unable to eat '.$item->name;
		if( $e->getMessage() ) {
			$message = $e->getMessage();
		}
		Page::add_message($message, Page::PAGE_MESSAGE_WARNING);
	}

	Page::redirect('dashboard');
?>