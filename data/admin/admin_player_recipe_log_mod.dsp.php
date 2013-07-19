<?php

  if(!isset($player_recipe_log_mod)) {
    $player_recipe_log_mod = Player_Recipe_Log::instance( getValue('id') );
  }

  if(is_null($player_recipe_log_mod->get_id())) {
    $form_url = get_page_url(PAGE_CODE);
    $PAGE_TITRE = 'Player Recipe Log : Ajouter';
  }else {
    $form_url = get_page_url(PAGE_CODE).'&id='.$player_recipe_log_mod->get_id();
    $PAGE_TITRE = 'Player Recipe Log : Mettre à jour les informations pour "'.$player_recipe_log_mod->get_id().'"';
  }

  $html_msg = '';

  if(isset($tab_error)) {
    if(Player_Recipe_Log::manage_errors($tab_error, $html_msg) === true) {
      $html_msg = '<p class="msg">Les informations de l\'objet Player Recipe Log ont été correctement enregistrées.</p>';
    }
  }

  echo '
  <div class="texte_contenu">
    <div class="texte_texte">
      <h3>'.$PAGE_TITRE.'</h3>
      '.$html_msg.'
      <form class="formulaire" action="'.$form_url.'" method="post">
        '.$player_recipe_log_mod->html_get_form();

  // CUSTOM

  //Custom content

  // /CUSTOM

        echo '
        <p>'.HTMLHelper::submit('player_recipe_log_submit', 'Sauvegarder les changements').'</p>
      </form>';

      if( $player_recipe_log_mod->id ) {
        echo '
      <p><a href="'.get_page_url('admin_player_recipe_log_view', true, array('id' => $player_recipe_log_mod->get_id())).'">Revenir à la page de l\'objet "'.$player_recipe_log_mod->get_id().'"</a></p>';
      }
      echo '
      <p><a href="'.get_page_url('admin_player_recipe_log').'">Revenir à la liste des objets Player Recipe Log</a></p>
    </div>
  </div>';