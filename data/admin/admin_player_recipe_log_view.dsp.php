<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$player_recipe_log->id;
  $PAGE_TITRE = 'Player Recipe Log : Showing "'.$player_recipe_log->id.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $player_recipe_log->id?>"</h3>
    <div class="informations formulaire">

<?php
      $option_list = array();
      $sub_player_list = Player::db_get_all();
      foreach( $sub_player_list as $sub_player)
        $option_list[ $sub_player->id ] = $sub_player->name;
?>
      <p class="field">
        <span class="libelle">Player Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_player_view', true, array('id' => $player_recipe_log->player_id ) )?>"><?php echo $option_list[ $player_recipe_log->player_id ]?></a></span>
      </p>

<?php
      $option_list = array();
      $sub_recipe_list = Recipe::db_get_all();
      foreach( $sub_recipe_list as $sub_recipe)
        $option_list[ $sub_recipe->id ] = $sub_recipe->name;
?>
      <p class="field">
        <span class="libelle">Recipe Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_recipe_view', true, array('id' => $player_recipe_log->recipe_id ) )?>"><?php echo $option_list[ $player_recipe_log->recipe_id ]?></a></span>
      </p>

            <p class="field">
              <span class="libelle">Time Taken</span>
              <span class="value"><?php echo is_array($player_recipe_log->time_taken)?nl2br(parameters_to_string( $player_recipe_log->time_taken )):$player_recipe_log->time_taken?></span>
            </p>
            <p class="field">
              <span class="libelle">Timestamp</span>
              <span class="value"><?php echo guess_time($player_recipe_log->timestamp, GUESS_DATETIME_LOCALE)?></span>
            </p>    </div>
    <p><a href="<?php echo get_page_url('admin_player_recipe_log_mod', true, array('id' => $player_recipe_log->id))?>">Modifier cet objet Player Recipe Log</a></p>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_player_recipe_log')?>">Revenir à la liste des objets Player Recipe Log</a></p>
  </div>
</div>