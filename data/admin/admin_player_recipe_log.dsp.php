<?php
  $PAGE_TITRE = "Administration des Player Recipe Logs";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Player_Recipe_Log::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Player_Recipe_Log::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Player Recipe Logs</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Id</th>
          <th>Player Id</th>
          <th>Recipe Id</th>
          <th>Time Taken</th>
          <th>Timestamp</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_player_recipe_log_mod').'">Ajouter manuellement un objet Player Recipe Log</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $player_recipe_log) {
      echo '
        <tr>
          <td><input type="checkbox" name="player_recipe_log_id[]" value="'.$player_recipe_log->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_player_recipe_log_view', array('id' => $player_recipe_log->id))).'">'.$player_recipe_log->get_id().'</a></td>
';
      $player_temp = Player::instance( $player_recipe_log->player_id);
      echo '
          <td>'.$player_temp->name.'</td>';
      $recipe_temp = Recipe::instance( $player_recipe_log->recipe_id);
      echo '
          <td>'.$recipe_temp->name.'</td>
          <td>'.(is_array($player_recipe_log->time_taken)?nl2br(parameters_to_string($player_recipe_log->time_taken)):$player_recipe_log->time_taken).'</td>
          <td>'.guess_time($player_recipe_log->timestamp, GUESS_DATETIME_LOCALE).'</td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_player_recipe_log_mod', array('id' => $player_recipe_log->id))).'"><i class="icon-pencil" title="Modifier"></i></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Player Recipe Log sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';