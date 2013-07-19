<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$item->id;
  $PAGE_TITRE = 'Item : Showing "'.$item->name.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $item->name?>"</h3>
    <div class="informations formulaire">

<?php
      $option_list = array();
      $sub_item_template_list = Item_Template::db_get_all();
      foreach( $sub_item_template_list as $sub_item_template)
        $option_list[ $sub_item_template->id ] = $sub_item_template->name;
?>
      <p class="field">
        <span class="libelle">Item Template Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_item_template_view', true, array('id' => $item->item_template_id ) )?>"><?php echo $option_list[ $item->item_template_id ]?></a></span>
      </p>

<?php
      $option_list = array(null => 'Pas de choix');
      $sub_player_list = Player::db_get_all();
      foreach( $sub_player_list as $sub_player)
        $option_list[ $sub_player->id ] = $sub_player->name;
?>
      <p class="field">
        <span class="libelle">Owner Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_player_view', true, array('id' => $item->owner_id ) )?>"><?php echo $option_list[ $item->owner_id ]?></a></span>
      </p>

            <p class="field">
              <span class="libelle">Quality</span>
              <span class="value"><?php echo is_array($item->quality)?nl2br(parameters_to_string( $item->quality )):$item->quality?></span>
            </p>
            <p class="field">
              <span class="libelle">Clock</span>
              <span class="value"><?php echo is_array($item->clock)?nl2br(parameters_to_string( $item->clock )):$item->clock?></span>
            </p>
            <p class="field">
              <span class="libelle">Obsolete</span>
              <span class="value"><?php echo is_array($item->obsolete)?nl2br(parameters_to_string( $item->obsolete )):$item->obsolete?></span>
            </p>
            <p class="field">
              <span class="libelle">Created</span>
              <span class="value"><?php echo guess_time($item->created, GUESS_DATETIME_LOCALE)?></span>
            </p>
            <p class="field">
              <span class="libelle">Destroyed</span>
              <span class="value"><?php echo guess_time($item->destroyed, GUESS_DATETIME_LOCALE)?></span>
            </p>    </div>
    <p><a href="<?php echo get_page_url('admin_item_mod', true, array('id' => $item->id))?>">Modifier cet objet Item</a></p>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_item')?>">Revenir à la liste des objets Item</a></p>
  </div>
</div>