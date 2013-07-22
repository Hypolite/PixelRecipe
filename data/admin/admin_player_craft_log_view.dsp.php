<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$player_craft_log->id;
  $PAGE_TITRE = 'Player Craft Log : Showing "'.$player_craft_log->id.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $player_craft_log->id?>"</h3>
    <div class="informations formulaire">

<?php
      $option_list = array();
      $sub_player_list = Player::db_get_all();
      foreach( $sub_player_list as $sub_player)
        $option_list[ $sub_player->id ] = $sub_player->name;
?>
      <p class="field">
        <span class="libelle">Player Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_player_view', true, array('id' => $player_craft_log->player_id ) )?>"><?php echo $option_list[ $player_craft_log->player_id ]?></a></span>
      </p>

<?php
      $option_list = array();
      $sub_blueprint_list = Blueprint::db_get_all();
      foreach( $sub_blueprint_list as $sub_blueprint)
        $option_list[ $sub_blueprint->id ] = $sub_blueprint->name;
?>
      <p class="field">
        <span class="libelle">Blueprint Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_blueprint_view', true, array('id' => $player_craft_log->blueprint_id ) )?>"><?php echo $option_list[ $player_craft_log->blueprint_id ]?></a></span>
      </p>

            <p class="field">
              <span class="libelle">Time Taken</span>
              <span class="value"><?php echo is_array($player_craft_log->time_taken)?nl2br(parameters_to_string( $player_craft_log->time_taken )):$player_craft_log->time_taken?></span>
            </p>
            <p class="field">
              <span class="libelle">Timestamp</span>
              <span class="value"><?php echo guess_time($player_craft_log->timestamp, GUESS_DATETIME_LOCALE)?></span>
            </p>    </div>
    <p><a href="<?php echo get_page_url('admin_player_craft_log_mod', true, array('id' => $player_craft_log->id))?>">Modifier cet objet Player Craft Log</a></p>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_player_craft_log')?>">Revenir à la liste des objets Player Craft Log</a></p>
  </div>
</div>