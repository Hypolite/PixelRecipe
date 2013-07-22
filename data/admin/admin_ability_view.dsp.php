<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$ability->id;
  $PAGE_TITRE = 'Ability : Showing "'.$ability->name.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $ability->name?>"</h3>
    <div class="informations formulaire">
    </div>
    <p><a href="<?php echo get_page_url('admin_ability_mod', true, array('id' => $ability->id))?>">Modifier cet objet Ability</a></p>
    <h4>Blueprint Ability</h4>
<?php

  $blueprint_ability_list = $ability->get_blueprint_ability_list();

  if(count($blueprint_ability_list)) {
?>
    <table class="table table-bordered table-condensed table-striped table-striped">
      <thead>
        <tr>
          <th>Blueprint</th>
          <th>Points Needed</th>          <th>Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="3"><?php echo count( $blueprint_ability_list )?> lignes</td>
        </tr>
      </tfoot>
      <tbody>
<?php
      foreach( $blueprint_ability_list as $blueprint_ability ) {

 
        $blueprint_id_blueprint = Blueprint::instance( $blueprint_ability['blueprint_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_blueprint_view', true, array('id' => $blueprint_id_blueprint->id)).'">'.$blueprint_id_blueprint->name.'</a></td>
        <td>'.$blueprint_ability['points_needed'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $ability->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $ability->id).'

              '.HTMLHelper::genererInputHidden('blueprint_id', $blueprint_id_blueprint->id).'              '.HTMLHelper::genererButton('action',  'del_blueprint_ability', array('type' => 'submit'), 'Supprimer').'
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

  $liste_valeurs_blueprint = Blueprint::db_get_select_list();?>
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $ability->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $ability->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('blueprint_id', $liste_valeurs_blueprint, null, array(), 'Blueprint' )?><a href="<?php echo get_page_url('admin_blueprint_mod')?>">Créer un objet Blueprint</a>
        </p>
        <p class="field">
          <?php echo HTMLHelper::genererInputText('points_needed', null, array(), 'Points Needed*' )?>
          
        </p>
        <p><?php echo HTMLHelper::genererButton('action',  'set_blueprint_ability', array('type' => 'submit'), 'Ajouter un élément')?></p>
      </fieldset>
    </form>
    <h4>Item Template Ability</h4>
<?php

  $item_template_ability_list = $ability->get_item_template_ability_list();

  if(count($item_template_ability_list)) {
?>
    <table class="table table-bordered table-condensed table-striped table-striped">
      <thead>
        <tr>
          <th>Item Template</th>
          <th>Points Provided</th>          <th>Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="3"><?php echo count( $item_template_ability_list )?> lignes</td>
        </tr>
      </tfoot>
      <tbody>
<?php
      foreach( $item_template_ability_list as $item_template_ability ) {

 
        $item_template_id_item_template = Item_Template::instance( $item_template_ability['item_template_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_item_template_view', true, array('id' => $item_template_id_item_template->id)).'">'.$item_template_id_item_template->name.'</a></td>
        <td>'.$item_template_ability['points_provided'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $ability->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $ability->id).'

              '.HTMLHelper::genererInputHidden('item_template_id', $item_template_id_item_template->id).'              '.HTMLHelper::genererButton('action',  'del_item_template_ability', array('type' => 'submit'), 'Supprimer').'
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

  $liste_valeurs_item_template = Item_Template::db_get_select_list();?>
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $ability->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $ability->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('item_template_id', $liste_valeurs_item_template, null, array(), 'Item Template' )?><a href="<?php echo get_page_url('admin_item_template_mod')?>">Créer un objet Item Template</a>
        </p>
        <p class="field">
          <?php echo HTMLHelper::genererInputText('points_provided', null, array(), 'Points Provided*' )?>
          
        </p>
        <p><?php echo HTMLHelper::genererButton('action',  'set_item_template_ability', array('type' => 'submit'), 'Ajouter un élément')?></p>
      </fieldset>
    </form>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_ability')?>">Revenir à la liste des objets Ability</a></p>
  </div>
</div>