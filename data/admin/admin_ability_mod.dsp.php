<?php

  if(!isset($ability_mod)) {
    $ability_mod = Ability::instance( getValue('id') );
  }

  if(is_null($ability_mod->get_id())) {
    $form_url = get_page_url(PAGE_CODE);
    $PAGE_TITRE = 'Ability : Ajouter';
  }else {
    $form_url = get_page_url(PAGE_CODE).'&id='.$ability_mod->get_id();
    $PAGE_TITRE = 'Ability : Mettre à jour les informations pour "'.$ability_mod->get_name().'"';
  }

  $html_msg = '';

  if(isset($tab_error)) {
    if(Ability::manage_errors($tab_error, $html_msg) === true) {
      $html_msg = '<p class="msg">Les informations de l\'objet Ability ont été correctement enregistrées.</p>';
    }
  }

  echo '
  <div class="texte_contenu">
    <div class="texte_texte">
      <h3>'.$PAGE_TITRE.'</h3>
      '.$html_msg.'
      <form class="formulaire" action="'.$form_url.'" method="post">
        '.$ability_mod->html_get_form();

  // CUSTOM

  //Custom content

  // /CUSTOM

        echo '
        <p>'.HTMLHelper::submit('ability_submit', 'Sauvegarder les changements').'</p>
      </form>';

      if( $ability_mod->id ) {
        echo '
      <p><a href="'.get_page_url('admin_ability_view', true, array('id' => $ability_mod->get_id())).'">Revenir à la page de l\'objet "'.$ability_mod->get_name().'"</a></p>';
      }
      echo '
      <p><a href="'.get_page_url('admin_ability').'">Revenir à la liste des objets Ability</a></p>
    </div>
  </div>';