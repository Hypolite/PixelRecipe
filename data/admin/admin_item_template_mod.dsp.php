<?php

  if(!isset($item_template_mod)) {
    $item_template_mod = Item_Template::instance( getValue('id') );
  }

  if(is_null($item_template_mod->get_id())) {
    $form_url = get_page_url(PAGE_CODE);
    $PAGE_TITRE = 'Item Template : Ajouter';
  }else {
    $form_url = get_page_url(PAGE_CODE).'&id='.$item_template_mod->get_id();
    $PAGE_TITRE = 'Item Template : Mettre à jour les informations pour "'.$item_template_mod->get_name().'"';
  }

  $html_msg = '';

  if(isset($tab_error)) {
    if(Item_Template::manage_errors($tab_error, $html_msg) === true) {
      $html_msg = '<p class="msg">Les informations de l\'objet Item Template ont été correctement enregistrées.</p>';
    }
  }

  echo '
  <div class="texte_contenu">
    <div class="texte_texte">
      <h3>'.$PAGE_TITRE.'</h3>
      '.$html_msg.'
      <form class="formulaire" action="'.$form_url.'" method="post">
        '.$item_template_mod->html_get_form();

  // CUSTOM

  //Custom content

  // /CUSTOM

        echo '
        <p>'.HTMLHelper::submit('item_template_submit', 'Sauvegarder les changements').'</p>
      </form>';

      if( $item_template_mod->id ) {
        echo '
      <p><a href="'.get_page_url('admin_item_template_view', true, array('id' => $item_template_mod->get_id())).'">Revenir à la page de l\'objet "'.$item_template_mod->get_name().'"</a></p>';
      }
      echo '
      <p><a href="'.get_page_url('admin_item_template').'">Revenir à la liste des objets Item Template</a></p>
    </div>
  </div>';