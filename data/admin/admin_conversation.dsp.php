<?php
  $PAGE_TITRE = "Administration des Conversations";

  $page_no = getValue('p', 1);
  $nb_per_page = NB_PER_PAGE;
  $tab = Conversation::db_get_all($page_no, $nb_per_page, true);
  $nb_total = Conversation::db_count_all(true);

    echo '
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Liste des Conversations</h3>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
    <form action="'.Page::get_url(PAGE_CODE).'" method="post">
    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>Sel.</th>
          <th>Id</th>
          <th>Player Id</th>
          <th>Game Id</th>
          <th>Subject</th>
          <th>Created</th>        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="6">'.$nb_total.' éléments | <a href="'.Page::get_url('admin_conversation_mod').'">Ajouter manuellement un objet Conversation</a></td>
        </tr>
      </tfoot>
      <tbody>';
    $tab_visible = array('0' => 'Non', '1' => 'Oui');
    foreach($tab as $conversation) {
      echo '
        <tr>
          <td><input type="checkbox" name="conversation_id[]" value="'.$conversation->id.'"/></td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_conversation_view', array('id' => $conversation->id))).'">'.$conversation->get_id().'</a></td>
';
      $player_temp = Player::instance( $conversation->player_id);
      echo '
          <td>'.$player_temp->name.'</td>
          <td>'.(is_array($conversation->game_id)?nl2br(parameters_to_string($conversation->game_id)):$conversation->game_id).'</td>
          <td>'.(is_array($conversation->subject)?nl2br(parameters_to_string($conversation->subject)):$conversation->subject).'</td>
          <td>'.guess_time($conversation->created, GUESS_DATETIME_LOCALE).'</td>
          <td><a href="'.htmlentities_utf8(Page::get_url('admin_conversation_mod', array('id' => $conversation->id))).'"><i class="icon-pencil" title="Modifier"></i></a></td>
        </tr>';
    }
    echo '
      </tbody>
    </table>
    <p>Pour les objets Conversation sélectionnés :
      <select name="action">
        <option value="delete">Delete</option>
      </select>
      <input type="submit" name="submit" value="Valider"/>
    </p>
    </form>
    '.nav_page(PAGE_CODE, $nb_total, $page_no, $nb_per_page).'
  </div>
</div>';