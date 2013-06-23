<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$item_template->id;
  $PAGE_TITRE = 'Item Template : Showing "'.$item_template->name.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $item_template->name?>"</h3>
    <div class="informations formulaire">

            <p class="field">
              <span class="libelle">Tech</span>
              <span class="value"><?php echo is_array($item_template->tech)?nl2br(parameters_to_string( $item_template->tech )):$item_template->tech?></span>
            </p>
            <p class="field">
              <span class="libelle">Type Id</span>
              <span class="value"><?php echo is_array($item_template->type_id)?nl2br(parameters_to_string( $item_template->type_id )):$item_template->type_id?></span>
            </p>    </div>
    <p><a href="<?php echo get_page_url('admin_item_template_mod', true, array('id' => $item_template->id))?>">Modifier cet objet Item Template</a></p>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_item_template')?>">Revenir à la liste des objets Item Template</a></p>
  </div>
</div>