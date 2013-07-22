<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$player_energy_log->id;
  $PAGE_TITRE = 'Player Energy Log : Showing "'.$player_energy_log->id.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $player_energy_log->id?>"</h3>
    <div class="informations formulaire">

<?php
      $option_list = array();
      $sub_player_list = Player::db_get_all();
      foreach( $sub_player_list as $sub_player)
        $option_list[ $sub_player->id ] = $sub_player->name;
?>
      <p class="field">
        <span class="libelle">Player Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_player_view', true, array('id' => $player_energy_log->player_id ) )?>"><?php echo $option_list[ $player_energy_log->player_id ]?></a></span>
      </p>

            <p class="field">
              <span class="libelle">Reason</span>
              <span class="value"><?php echo is_array($player_energy_log->reason)?nl2br(parameters_to_string( $player_energy_log->reason )):$player_energy_log->reason?></span>
            </p>
            <p class="field">
              <span class="libelle">Delta</span>
              <span class="value"><?php echo is_array($player_energy_log->delta)?nl2br(parameters_to_string( $player_energy_log->delta )):$player_energy_log->delta?></span>
            </p>
            <p class="field">
              <span class="libelle">Timestamp</span>
              <span class="value"><?php echo guess_time($player_energy_log->timestamp, GUESS_DATETIME_LOCALE)?></span>
            </p>    </div>
    <p><a href="<?php echo get_page_url('admin_player_energy_log_mod', true, array('id' => $player_energy_log->id))?>">Modifier cet objet Player Energy Log</a></p>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_player_energy_log')?>">Revenir à la liste des objets Player Energy Log</a></p>
  </div>
</div>