<?php
  $PAGE_TITRE = "Administration des Blueprints";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Blueprint::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Blueprint::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Blueprints</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Name</th>
          <th>Item Template</th>
          <th>Skill</th>
          <th>Time</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_blueprint_mod').'">Ajouter manuellement un objet Blueprint</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $blueprint) {
      echo '
        <tr>
          <td><input type="checkbox" name="blueprint_id[]" value="'.$blueprint->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_blueprint_view', array('id' => $blueprint->id))).'">'.$blueprint->get_name().'</a></td>
';
      $item_template_temp = Item_Template::instance( $blueprint->item_template_id);
      echo '
          <td>'.$item_template_temp->name.'</td>';
      $skill_temp = Skill::instance( $blueprint->skill_id);
      echo '
          <td>'.$skill_temp->name.'</td>
          <td>'.(is_array($blueprint->time)?nl2br(parameters_to_string($blueprint->time)):$blueprint->time).'</td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_blueprint_mod', array('id' => $blueprint->id))).'"><i class="icon-pencil" title="Modifier"></i></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Blueprint sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';