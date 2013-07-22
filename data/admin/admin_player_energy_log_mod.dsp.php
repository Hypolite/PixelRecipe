<?php

  if(!isset($player_energy_log_mod)) {
    $player_energy_log_mod = Player_Energy_Log::instance( getValue('id') );
  }

  if(is_null($player_energy_log_mod->get_id())) {
    $form_url = get_page_url(PAGE_CODE);
    $PAGE_TITRE = 'Player Energy Log : Ajouter';
  }else {
    $form_url = get_page_url(PAGE_CODE).'&id='.$player_energy_log_mod->get_id();
    $PAGE_TITRE = 'Player Energy Log : Mettre à jour les informations pour "'.$player_energy_log_mod->get_id().'"';
  }

  $html_msg = '';

  if(isset($tab_error)) {
    if(Player_Energy_Log::manage_errors($tab_error, $html_msg) === true) {
      $html_msg = '<p class="msg">Les informations de l\'objet Player Energy Log ont été correctement enregistrées.</p>';
    }
  }

  echo '
  <div class="texte_contenu">
    <div class="texte_texte">
      <h3>'.$PAGE_TITRE.'</h3>
      '.$html_msg.'
      <form class="formulaire" action="'.$form_url.'" method="post">
        '.$player_energy_log_mod->html_get_form();

  // CUSTOM

  //Custom content

  // /CUSTOM

        echo '
        <p>'.HTMLHelper::submit('player_energy_log_submit', 'Sauvegarder les changements').'</p>
      </form>';

      if( $player_energy_log_mod->id ) {
        echo '
      <p><a href="'.get_page_url('admin_player_energy_log_view', true, array('id' => $player_energy_log_mod->get_id())).'">Revenir à la page de l\'objet "'.$player_energy_log_mod->get_id().'"</a></p>';
      }
      echo '
      <p><a href="'.get_page_url('admin_player_energy_log').'">Revenir à la liste des objets Player Energy Log</a></p>
    </div>
  </div>';