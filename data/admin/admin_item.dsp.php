<?php
  $PAGE_TITRE = "Administration des Items";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Item::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Item::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Items</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Name</th>
          <th>Item Template</th>
          <th>Owner</th>
          <th>Quality</th>
          <th>Clock</th>
          <th>Obsolete</th>
          <th>Created</th>
          <th>Destroyed</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_item_mod').'">Ajouter manuellement un objet Item</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $item) {
      echo '
        <tr>
          <td><input type="checkbox" name="item_id[]" value="'.$item->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_item_view', array('id' => $item->id))).'">'.$item->get_name().'</a></td>
';
      $item_template_temp = Item_Template::instance( $item->item_template_id);
      echo '
          <td>'.$item_template_temp->name.'</td>';
      $player_temp = Player::instance( $item->owner_id);
      echo '
          <td>'.$player_temp->name.'</td>
          <td>'.(is_array($item->quality)?nl2br(parameters_to_string($item->quality)):$item->quality).'</td>
          <td>'.(is_array($item->clock)?nl2br(parameters_to_string($item->clock)):$item->clock).'</td>
          <td>'.(is_array($item->obsolete)?nl2br(parameters_to_string($item->obsolete)):$item->obsolete).'</td>
          <td>'.guess_time($item->created, GUESS_DATETIME_LOCALE).'</td>
          <td>'.guess_time($item->destroyed, GUESS_DATETIME_LOCALE).'</td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_item_mod', array('id' => $item->id))).'"><i class="icon-pencil" title="Modifier"></i></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Item sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';