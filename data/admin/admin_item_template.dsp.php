<?php
  $PAGE_TITRE = "Administration des Item Templates";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Item_Template::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Item_Template::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Item Templates</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Name</th>
          <th>Tech</th>
          <th>Type Id</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_item_template_mod').'">Ajouter manuellement un objet Item Template</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $item_template) {
      echo '
        <tr>
          <td><input type="checkbox" name="item_template_id[]" value="'.$item_template->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_item_template_view', array('id' => $item_template->id))).'">'.$item_template->get_name().'</a></td>

          <td>'.(is_array($item_template->tech)?nl2br(parameters_to_string($item_template->tech)):$item_template->tech).'</td>
          <td>'.(is_array($item_template->type_id)?nl2br(parameters_to_string($item_template->type_id)):$item_template->type_id).'</td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_item_template_mod', array('id' => $item_template->id))).'"><img src="'.IMG.'img_html/pencil.png" alt="Modifier" title="Modifier"/></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Item Template sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';