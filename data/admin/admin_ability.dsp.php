<?php
  $PAGE_TITRE = "Administration des Abilitys";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Ability::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Ability::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Abilitys</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Name</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_ability_mod').'">Ajouter manuellement un objet Ability</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $ability) {
      echo '
        <tr>
          <td><input type="checkbox" name="ability_id[]" value="'.$ability->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_ability_view', array('id' => $ability->id))).'">'.$ability->get_name().'</a></td>

          <td><a href="'.htmlentities_utf8(Page::get_url('admin_ability_mod', array('id' => $ability->id))).'"><i class="icon-pencil" title="Modifier"></i></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Ability sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';