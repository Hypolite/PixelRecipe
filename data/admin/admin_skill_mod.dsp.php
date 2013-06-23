<?php

  if(!isset($skill_mod)) {
    $skill_mod = Skill::instance( getValue('id') );
  }

  if(is_null($skill_mod->get_id())) {
    $form_url = get_page_url(PAGE_CODE);
    $PAGE_TITRE = 'Skill : Ajouter';
  }else {
    $form_url = get_page_url(PAGE_CODE).'&id='.$skill_mod->get_id();
    $PAGE_TITRE = 'Skill : Mettre à jour les informations pour "'.$skill_mod->get_name().'"';
  }

  $html_msg = '';

  if(isset($tab_error)) {
    if(Skill::manage_errors($tab_error, $html_msg) === true) {
      $html_msg = '<p class="msg">Les informations de l\'objet Skill ont été correctement enregistrées.</p>';
    }
  }

  echo '
  <div class="texte_contenu">
    <div class="texte_texte">
      <h3>'.$PAGE_TITRE.'</h3>
      '.$html_msg.'
      <form class="formulaire" action="'.$form_url.'" method="post">
        '.$skill_mod->html_get_form();

  // CUSTOM

  //Custom content

  // /CUSTOM

        echo '
        <p>'.HTMLHelper::submit('skill_submit', 'Sauvegarder les changements').'</p>
      </form>';

      if( $skill_mod->id ) {
        echo '
      <p><a href="'.get_page_url('admin_skill_view', true, array('id' => $skill_mod->get_id())).'">Revenir à la page de l\'objet "'.$skill_mod->get_name().'"</a></p>';
      }
      echo '
      <p><a href="'.get_page_url('admin_skill').'">Revenir à la liste des objets Skill</a></p>
    </div>
  </div>';