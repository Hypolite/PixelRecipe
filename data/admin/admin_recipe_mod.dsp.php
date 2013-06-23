<?php

  if(!isset($recipe_mod)) {
    $recipe_mod = Recipe::instance( getValue('id') );
  }

  if(is_null($recipe_mod->get_id())) {
    $form_url = get_page_url(PAGE_CODE);
    $PAGE_TITRE = 'Recipe : Ajouter';
  }else {
    $form_url = get_page_url(PAGE_CODE).'&id='.$recipe_mod->get_id();
    $PAGE_TITRE = 'Recipe : Mettre à jour les informations pour "'.$recipe_mod->get_name().'"';
  }

  $html_msg = '';

  if(isset($tab_error)) {
    if(Recipe::manage_errors($tab_error, $html_msg) === true) {
      $html_msg = '<p class="msg">Les informations de l\'objet Recipe ont été correctement enregistrées.</p>';
    }
  }

  echo '
  <div class="texte_contenu">
    <div class="texte_texte">
      <h3>'.$PAGE_TITRE.'</h3>
      '.$html_msg.'
      <form class="formulaire" action="'.$form_url.'" method="post">
        '.$recipe_mod->html_get_form();

  // CUSTOM

  //Custom content

  // /CUSTOM

        echo '
        <p>'.HTMLHelper::submit('recipe_submit', 'Sauvegarder les changements').'</p>
      </form>';

      if( $recipe_mod->id ) {
        echo '
      <p><a href="'.get_page_url('admin_recipe_view', true, array('id' => $recipe_mod->get_id())).'">Revenir à la page de l\'objet "'.$recipe_mod->get_name().'"</a></p>';
      }
      echo '
      <p><a href="'.get_page_url('admin_recipe').'">Revenir à la liste des objets Recipe</a></p>
    </div>
  </div>';