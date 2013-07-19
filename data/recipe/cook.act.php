<?php
	$member = Member::instance( Member::get_current_user_id() );

	$current_player = Player::get_current( $member );

	$recipe = Recipe::instance(getValue('recipe_id'));

	if( $recipe->id ) {
		if( $current_player->can_cook($recipe) ) {
			$current_player->cook( $recipe );
			Page::add_message('Recipe "'.$recipe->name.'" is cooked!');
		}else {
			Page::add_message('Unable to cook "'.$recipe->name.'"', Page::PAGE_MESSAGE_WARNING);
		}
	}

	Page::redirect('dashboard');
?>