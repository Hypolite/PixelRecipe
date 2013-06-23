<?php
  $PAGE_TITRE = "Administration des Item Types";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Item_Type::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Item_Type::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Item Types</h3>
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
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_item_type_mod').'">Ajouter manuellement un objet Item Type</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $item_type) {
      echo '
        <tr>
          <td><input type="checkbox" name="item_type_id[]" value="'.$item_type->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_item_type_view', array('id' => $item_type->id))).'">'.$item_type->get_name().'</a></td>

          <td><a href="'.htmlentities_utf8(Page::get_url('admin_item_type_mod', array('id' => $item_type->id))).'"><img src="'.IMG.'img_html/pencil.png" alt="Modifier" title="Modifier"/></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Item Type sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';