<?php
  $PAGE_TITRE = "Administration des Recipes";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Recipe::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Recipe::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Recipes</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Name</th>
          <th>Item Template Id</th>
          <th>Time</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_recipe_mod').'">Ajouter manuellement un objet Recipe</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $recipe) {
      echo '
        <tr>
          <td><input type="checkbox" name="recipe_id[]" value="'.$recipe->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_recipe_view', array('id' => $recipe->id))).'">'.$recipe->get_name().'</a></td>
';
      $item_template_temp = Item_Template::instance( $recipe->item_template_id);
      echo '
          <td>'.$item_template_temp->name.'</td>
          <td>'.(is_array($recipe->time)?nl2br(parameters_to_string($recipe->time)):$recipe->time).'</td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_recipe_mod', array('id' => $recipe->id))).'"><img src="'.IMG.'img_html/pencil.png" alt="Modifier" title="Modifier"/></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Recipe sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';