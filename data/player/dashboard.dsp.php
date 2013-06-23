<?php
  $players = Player::db_get_by_member_id( $member->id );
  /* @var $current_player Player */

?>
<h2><?php echo __('Dashboard')?></h2>
<p><?php echo __('Welcome %s !', $current_player->get_name())?></p>
<p>Player ID : <?php echo $current_player->id?></p>
<p>API Key : <?php echo $current_player->api_key?></p>
<p>API Signature : <?php echo sha1( $current_player->id . $current_player->api_key )?></p>
<?php if ( 1 == 2 ) {?>
<ul>
  <?php foreach( $players as $player ) {?>
  <li><a href="<?php echo Page::get_url(PAGE_CODE, array('player_id' => $player->id ))?>"><?php echo $player->name?></a></li>
  <?php } ?>
</ul>
<p><a href="<?php echo Page::get_url('create_player')?>">Create player</a></p>
<?php }?>

<h4><?php echo __('Wall')?></h4>
<form action="<?php echo Page::get_url('shout')?>" method="post">
  <p><?php echo '['.guess_time(time(), GUESS_TIME_LOCALE).']'?> <strong><?php echo wash_utf8($current_player->name)?></strong> : <input type="text" name="text" size="80" value=""/><button type="submit" name="action" value="shout">Say</button></p>
</form>
<div id="shoutwall">
<?php
    $shouts = Shout::db_get_all();
    foreach( array_reverse( $shouts ) as $shout ) {
      $player = Player::instance($shout->shouter_id);
      echo '
  <div class="shout">['.guess_time($shout->date_sent, GUESS_TIME_LOCALE).'] <strong>'.wash_utf8($player->name).'</strong>: '.wash_utf8($shout->text).'</div>';
    }
?>
</div>
<h3>Recipes</h3>
<?php
	$gather_recipes = Recipe::get_gather_list();

	var_debug( $gather_recipes );
?>