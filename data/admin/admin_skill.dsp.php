<?php
  $PAGE_TITRE = "Administration des Skills";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Skill::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Skill::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Skills</h3>
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
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_skill_mod').'">Ajouter manuellement un objet Skill</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $skill) {
      echo '
        <tr>
          <td><input type="checkbox" name="skill_id[]" value="'.$skill->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_skill_view', array('id' => $skill->id))).'">'.$skill->get_name().'</a></td>

          <td><a href="'.htmlentities_utf8(Page::get_url('admin_skill_mod', array('id' => $skill->id))).'"><img src="'.IMG.'img_html/pencil.png" alt="Modifier" title="Modifier"/></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Skill sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';