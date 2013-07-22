<?php
  $PAGE_TITRE = "Administration des Player Craft Logs";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Player_Craft_Log::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Player_Craft_Log::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Player Craft Logs</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Id</th>
          <th>Player</th>
          <th>Blueprint</th>
          <th>Time Taken</th>
          <th>Timestamp</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_player_craft_log_mod').'">Ajouter manuellement un objet Player Craft Log</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $player_craft_log) {
      echo '
        <tr>
          <td><input type="checkbox" name="player_craft_log_id[]" value="'.$player_craft_log->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_player_craft_log_view', array('id' => $player_craft_log->id))).'">'.$player_craft_log->get_id().'</a></td>
';
      $player_temp = Player::instance( $player_craft_log->player_id);
      echo '
          <td>'.$player_temp->name.'</td>';
      $blueprint_temp = Blueprint::instance( $player_craft_log->blueprint_id);
      echo '
          <td>'.$blueprint_temp->name.'</td>
          <td>'.(is_array($player_craft_log->time_taken)?nl2br(parameters_to_string($player_craft_log->time_taken)):$player_craft_log->time_taken).'</td>
          <td>'.guess_time($player_craft_log->timestamp, GUESS_DATETIME_LOCALE).'</td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_player_craft_log_mod', array('id' => $player_craft_log->id))).'"><i class="icon-pencil" title="Modifier"></i></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Player Craft Log sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';