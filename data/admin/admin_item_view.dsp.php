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
      $item_template_list = Item_Template::db_get_all();
      foreach( $item_template_list as $item_template)
        $option_list[ $item_template->id ] = $item_template->name;
?>
      <p class="field">
        <span class="libelle">Item Template Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_item_template_view', true, array('id' => $item->item_template_id ) )?>"><?php echo $option_list[ $item->item_template_id ]?></a></span>
      </p>

<?php
      $option_list = array();
      $player_list = Player::db_get_all();
      foreach( $player_list as $player)
        $option_list[ $player->id ] = $player->name;
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
              <span class="libelle">Created</span>
              <span class="value"><?php echo guess_time($item->created, GUESS_DATETIME_LOCALE)?></span>
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