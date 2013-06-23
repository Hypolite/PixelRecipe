<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$item_type->id;
  $PAGE_TITRE = 'Item Type : Showing "'.$item_type->name.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $item_type->name?>"</h3>
    <div class="informations formulaire">
    </div>
    <p><a href="<?php echo get_page_url('admin_item_type_mod', true, array('id' => $item_type->id))?>">Modifier cet objet Item Type</a></p>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_item_type')?>">Revenir à la liste des objets Item Type</a></p>
  </div>
</div>