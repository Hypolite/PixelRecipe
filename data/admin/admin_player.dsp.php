<?php
  $PAGE_TITRE = "Administration des Players";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Player::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Player::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Players</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Name</th>
          <th>Member</th>
          <th>Active</th>
          <th>Api Key</th>
          <th>Max Energy</th>
          <th>Last Active</th>
          <th>Created</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_player_mod').'">Ajouter manuellement un objet Player</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $player) {
      echo '
        <tr>
          <td><input type="checkbox" name="player_id[]" value="'.$player->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_player_view', array('id' => $player->id))).'">'.$player->get_name().'</a></td>
';
      $member_temp = Member::instance( $player->member_id);
      echo '
          <td>'.$member_temp->name.'</td>
          <td>'.$tab_visible[$player->active].'</td>
          <td>'.(is_array($player->api_key)?nl2br(parameters_to_string($player->api_key)):$player->api_key).'</td>
          <td>'.(is_array($player->max_energy)?nl2br(parameters_to_string($player->max_energy)):$player->max_energy).'</td>
          <td>'.guess_time($player->last_active, GUESS_DATETIME_LOCALE).'</td>
          <td>'.guess_time($player->created, GUESS_DATETIME_LOCALE).'</td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_player_mod', array('id' => $player->id))).'"><i class="icon-pencil" title="Modifier"></i></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Player sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';