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
<h3>Energy</h3>
<ul>
    <li><?php echo $current_player->get_current_energy()?>/<?php echo $current_player->max_energy?></li>
</ul>
<h3>Inventory</h3>
<ul>
<?php foreach( $current_player->get_inventory_list() as $item ):?>
	<li><?php echo $item->name?> <?php if($item->is_edible()):?><a href="<?php echo Page::get_url('eat', array('item_id' => $item->id));?>">Eat</a><?php endif;?></li>
<?php endforeach;?>
</ul>
<h3>Blueprints</h3>
<h4>Gathering</h4>
<?php
	$gather_blueprints = Blueprint::get_gather_list();
?>
<ul>
<?php foreach( $gather_blueprints as $blueprint ) :?>
	<li><a href="<?php echo Page::get_url('craft', array('blueprint_id' => $blueprint->id))?>"><?php echo $blueprint->name?></a></li>
<?php endforeach;?>
</ul>
<h4>Craft</h4>
<?php
	$gather_blueprints = Blueprint::get_available_blueprint_list( $current_player );
?>
<ul>
<?php foreach( $gather_blueprints as $blueprint ) :?>
	<li><a href="<?php echo Page::get_url('craft', array('blueprint_id' => $blueprint->id))?>"><?php echo $blueprint->name?></a></li>
<?php endforeach;?>
</ul>
