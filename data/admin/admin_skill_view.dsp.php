<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$skill->id;
  $PAGE_TITRE = 'Skill : Showing "'.$skill->name.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $skill->name?>"</h3>
    <div class="informations formulaire">
    </div>
    <p><a href="<?php echo get_page_url('admin_skill_mod', true, array('id' => $skill->id))?>">Modifier cet objet Skill</a></p>
    <h4>Player Skill</h4>
<?php

  $player_skill_list = $skill->get_player_skill_list();

  if(count($player_skill_list)) {
?>
    <table>
      <thead>
        <tr>
          <th>Player Id</th>
          <th>Experience</th>          <th>Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="3"><?php echo count( $player_skill_list )?> lignes</td>
        </tr>
      </tfoot>
      <tbody>
<?php
      foreach( $player_skill_list as $player_skill ) {

 
        $player_id_player = Player::instance( $player_skill['player_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_player_view', true, array('id' => $player_id_player->id)).'">'.$player_id_player->name.'</a></td>
        <td>'.$player_skill['experience'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $skill->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $skill->id).'

              '.HTMLHelper::genererInputHidden('player_id', $player_id_player->id).'              '.HTMLHelper::genererButton('action',  'del_player_skill', array('type' => 'submit'), 'Supprimer').'
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

  $liste_valeurs_player = Player::db_get_select_list();?>
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $skill->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $skill->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('player_id', $liste_valeurs_player, null, array(), 'Player' )?><a href="<?php echo get_page_url('admin_player_mod')?>">Créer un objet Player</a>
        </p>
        <p class="field">
          <?php echo HTMLHelper::genererInputText('experience', null, array(), 'Experience*' )?>
           
        </p>
        <p><?php echo HTMLHelper::genererButton('action',  'set_player_skill', array('type' => 'submit'), 'Ajouter un élément')?></p>
      </fieldset>
    </form>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_skill')?>">Revenir à la liste des objets Skill</a></p>
  </div>
</div>