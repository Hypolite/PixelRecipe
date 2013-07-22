<?php
	$member = Member::instance( Member::get_current_user_id() );

	$current_player = Player::get_current( $member );

	$recipe = Recipe::instance(getValue('recipe_id'));

	if( $recipe->id ) {
		try {
			$current_player->craft( $recipe );
			Page::add_message('Recipe "'.$recipe->name.'" is crafted!');
		}catch( Exception $e ) {
			Page::add_message('Unable to craft "'.$recipe->name.'"', Page::PAGE_MESSAGE_WARNING);
		}
	}

	Page::redirect('dashboard');
?>