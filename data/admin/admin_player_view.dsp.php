<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$player->id;
  $PAGE_TITRE = 'Player : Showing "'.$player->name.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $player->name?>"</h3>
    <div class="informations formulaire">

<?php
      $option_list = array();
      $member_list = Member::db_get_all();
      foreach( $member_list as $member)
        $option_list[ $member->id ] = $member->name;
?>
      <p class="field">
        <span class="libelle">Member Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_member_view', true, array('id' => $player->member_id ) )?>"><?php echo $option_list[ $player->member_id ]?></a></span>
      </p>

            <p class="field">
              <span class="libelle">Active</span>
              <span class="value"><?php echo $tab_visible[$player->active]?></span>
            </p>
            <p class="field">
              <span class="libelle">Api Key</span>
              <span class="value"><?php echo is_array($player->api_key)?nl2br(parameters_to_string( $player->api_key )):$player->api_key?></span>
            </p>
            <p class="field">
              <span class="libelle">Created</span>
              <span class="value"><?php echo guess_time($player->created, GUESS_DATETIME_LOCALE)?></span>
            </p>    </div>
    <p><a href="<?php echo get_page_url('admin_player_mod', true, array('id' => $player->id))?>">Modifier cet objet Player</a></p>
    <h4>Message Recipient</h4>
<?php

  $message_recipient_list = $player->get_message_recipient_list();

  if(count($message_recipient_list)) {
?>
    <table>
      <thead>
        <tr>
          <th>Message Id</th>
          <th>Read</th>          <th>Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="3"><?php echo count( $message_recipient_list )?> lignes</td>
        </tr>
      </tfoot>
      <tbody>
<?php
      foreach( $message_recipient_list as $message_recipient ) {

 
        $message_id_message = Message::instance( $message_recipient['message_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_message_view', true, array('id' => $message_id_message->id)).'">'.$message_id_message->id.'</a></td>
        <td>'.$message_recipient['read'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $player->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $player->id).'

              '.HTMLHelper::genererInputHidden('message_id', $message_id_message->id).'              '.HTMLHelper::genererButton('action',  'del_message_recipient', array('type' => 'submit'), 'Supprimer').'
            </form>
          </td>
        </tr>';
      }
?>
      </tbody>
    </table>
<?php
  }else {
    echo '<p>Il n\'y a pas d\'éléments à afficher</p>';
  }

  $liste_valeurs_message = Message::db_get_select_list();?>
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $player->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $player->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('message_id', $liste_valeurs_message, null, array(), 'Message' )?><a href="<?php echo get_page_url('admin_message_mod')?>">Créer un objet Message</a>
        </p>
        <p class="field">
          <?php echo HTMLHelper::genererInputText('read', null, array(), 'Read' )?>
          <span><?php echo guess_time(time(), GUESS_TIME_MYSQL)?></span> 
        </p>
        <p><?php echo HTMLHelper::genererButton('action',  'set_message_recipient', array('type' => 'submit'), 'Ajouter un élément')?></p>
      </fieldset>
    </form>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_player')?>">Revenir à la liste des objets Player</a></p>
  </div>
</div>