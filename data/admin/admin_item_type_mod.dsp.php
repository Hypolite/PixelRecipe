<?php

  if(!isset($item_type_mod)) {
    $item_type_mod = Item_Type::instance( getValue('id') );
  }

  if(is_null($item_type_mod->get_id())) {
    $form_url = get_page_url(PAGE_CODE);
    $PAGE_TITRE = 'Item Type : Ajouter';
  }else {
    $form_url = get_page_url(PAGE_CODE).'&id='.$item_type_mod->get_id();
    $PAGE_TITRE = 'Item Type : Mettre à jour les informations pour "'.$item_type_mod->get_name().'"';
  }

  $html_msg = '';

  if(isset($tab_error)) {
    if(Item_Type::manage_errors($tab_error, $html_msg) === true) {
      $html_msg = '<p class="msg">Les informations de l\'objet Item Type ont été correctement enregistrées.</p>';
    }
  }

  echo '
  <div class="texte_contenu">
    <div class="texte_texte">
      <h3>'.$PAGE_TITRE.'</h3>
      '.$html_msg.'
      <form class="formulaire" action="'.$form_url.'" method="post">
        '.$item_type_mod->html_get_form();

  // CUSTOM

  //Custom content

  // /CUSTOM

        echo '
        <p>'.HTMLHelper::submit('item_type_submit', 'Sauvegarder les changements').'</p>
      </form>';

      if( $item_type_mod->id ) {
        echo '
      <p><a href="'.get_page_url('admin_item_type_view', true, array('id' => $item_type_mod->get_id())).'">Revenir à la page de l\'objet "'.$item_type_mod->get_name().'"</a></p>';
      }
      echo '
      <p><a href="'.get_page_url('admin_item_type').'">Revenir à la liste des objets Item Type</a></p>
    </div>
  </div>';