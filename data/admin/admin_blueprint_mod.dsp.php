<?php

  if(!isset($blueprint_mod)) {
    $blueprint_mod = Blueprint::instance( getValue('id') );
  }

  if(is_null($blueprint_mod->get_id())) {
    $form_url = get_page_url(PAGE_CODE);
    $PAGE_TITRE = 'Blueprint : Ajouter';
  }else {
    $form_url = get_page_url(PAGE_CODE).'&id='.$blueprint_mod->get_id();
    $PAGE_TITRE = 'Blueprint : Mettre à jour les informations pour "'.$blueprint_mod->get_name().'"';
  }

  $html_msg = '';

  if(isset($tab_error)) {
    if(Blueprint::manage_errors($tab_error, $html_msg) === true) {
      $html_msg = '<p class="msg">Les informations de l\'objet Blueprint ont été correctement enregistrées.</p>';
    }
  }

  echo '
  <div class="texte_contenu">
    <div class="texte_texte">
      <h3>'.$PAGE_TITRE.'</h3>
      '.$html_msg.'
      <form class="formulaire" action="'.$form_url.'" method="post">
        '.$blueprint_mod->html_get_form();

  // CUSTOM

  //Custom content

  // /CUSTOM

        echo '
        <p>'.HTMLHelper::submit('blueprint_submit', 'Sauvegarder les changements').'</p>
      </form>';

      if( $blueprint_mod->id ) {
        echo '
      <p><a href="'.get_page_url('admin_blueprint_view', true, array('id' => $blueprint_mod->get_id())).'">Revenir à la page de l\'objet "'.$blueprint_mod->get_name().'"</a></p>';
      }
      echo '
      <p><a href="'.get_page_url('admin_blueprint').'">Revenir à la liste des objets Blueprint</a></p>
    </div>
  </div>';