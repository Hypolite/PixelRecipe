<?php
  $PAGE_TITRE = "Administration des Player Energy Logs";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Player_Energy_Log::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Player_Energy_Log::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Player Energy Logs</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Id</th>
          <th>Player</th>
          <th>Reason</th>
          <th>Delta</th>
          <th>Timestamp</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_player_energy_log_mod').'">Ajouter manuellement un objet Player Energy Log</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $player_energy_log) {
      echo '
        <tr>
          <td><input type="checkbox" name="player_energy_log_id[]" value="'.$player_energy_log->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_player_energy_log_view', array('id' => $player_energy_log->id))).'">'.$player_energy_log->get_id().'</a></td>
';
      $player_temp = Player::instance( $player_energy_log->player_id);
      echo '
          <td>'.$player_temp->name.'</td>
          <td>'.(is_array($player_energy_log->reason)?nl2br(parameters_to_string($player_energy_log->reason)):$player_energy_log->reason).'</td>
          <td>'.(is_array($player_energy_log->delta)?nl2br(parameters_to_string($player_energy_log->delta)):$player_energy_log->delta).'</td>
          <td>'.guess_time($player_energy_log->timestamp, GUESS_DATETIME_LOCALE).'</td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_player_energy_log_mod', array('id' => $player_energy_log->id))).'"><i class="icon-pencil" title="Modifier"></i></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Player Energy Log sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';