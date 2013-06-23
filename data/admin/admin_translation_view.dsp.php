<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$translation->id;
  $PAGE_TITRE = 'Translation : Showing "'.$translation->id.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $translation->id?>"</h3>
    <div class="informations formulaire">

            <p class="field">
              <span class="libelle">Code</span>
              <span class="value"><?php echo is_array($translation->code)?nl2br(parameters_to_string( $translation->code )):$translation->code?></span>
            </p>
            <p class="field">
              <span class="libelle">Locale</span>
              <span class="value"><?php echo is_array($translation->locale)?nl2br(parameters_to_string( $translation->locale )):$translation->locale?></span>
            </p>
            <p class="field">
              <span class="libelle">Translation</span>
              <span class="value"><?php echo is_array($translation->translation)?nl2br(parameters_to_string( $translation->translation )):$translation->translation?></span>
            </p>
            <p class="field">
              <span class="libelle">Context</span>
              <span class="value"><?php echo is_array($translation->context)?nl2br(parameters_to_string( $translation->context )):$translation->context?></span>
            </p>
            <p class="field">
              <span class="libelle">Translator Id</span>
              <span class="value"><?php echo is_array($translation->translator_id)?nl2br(parameters_to_string( $translation->translator_id )):$translation->translator_id?></span>
            </p>
            <p class="field">
              <span class="libelle">Created</span>
              <span class="value"><?php echo guess_time($translation->created, GUESS_DATETIME_LOCALE)?></span>
            </p>
            <p class="field">
              <span class="libelle">Updated</span>
              <span class="value"><?php echo guess_time($translation->updated, GUESS_DATETIME_LOCALE)?></span>
            </p>    </div>
    <p><a href="<?php echo get_page_url('admin_translation_mod', true, array('id' => $translation->id))?>">Modifier cet objet Translation</a></p>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_translation')?>">Revenir à la liste des objets Translation</a></p>
  </div>
</div>