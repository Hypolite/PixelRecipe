<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$recipe->id;
  $PAGE_TITRE = 'Recipe : Showing "'.$recipe->name.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $recipe->name?>"</h3>
    <div class="informations formulaire">

<?php
      $option_list = array();
      $sub_item_template_list = Item_Template::db_get_all();
      foreach( $sub_item_template_list as $sub_item_template)
        $option_list[ $sub_item_template->id ] = $sub_item_template->name;
?>
      <p class="field">
        <span class="libelle">Item Template Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_item_template_view', true, array('id' => $recipe->item_template_id ) )?>"><?php echo $option_list[ $recipe->item_template_id ]?></a></span>
      </p>

<?php
      $option_list = array(null => 'Pas de choix');
      $sub_skill_list = Skill::db_get_all();
      foreach( $sub_skill_list as $sub_skill)
        $option_list[ $sub_skill->id ] = $sub_skill->name;
?>
      <p class="field">
        <span class="libelle">Skill Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_skill_view', true, array('id' => $recipe->skill_id ) )?>"><?php echo $option_list[ $recipe->skill_id ]?></a></span>
      </p>

            <p class="field">
              <span class="libelle">Time</span>
              <span class="value"><?php echo is_array($recipe->time)?nl2br(parameters_to_string( $recipe->time )):$recipe->time?></span>
            </p>    </div>
    <p><a href="<?php echo get_page_url('admin_recipe_mod', true, array('id' => $recipe->id))?>">Modifier cet objet Recipe</a></p>
    <h4>Recipe Ability</h4>
<?php

  $recipe_ability_list = $recipe->get_recipe_ability_list();

  if(count($recipe_ability_list)) {
?>
    <table class="table table-bordered table-condensed table-striped table-striped">
      <thead>
        <tr>
          <th>Ability</th>
          <th>Points Needed</th>          <th>Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="3"><?php echo count( $recipe_ability_list )?> lignes</td>
        </tr>
      </tfoot>
      <tbody>
<?php
      foreach( $recipe_ability_list as $recipe_ability ) {

 
        $ability_id_ability = Ability::instance( $recipe_ability['ability_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_ability_view', true, array('id' => $ability_id_ability->id)).'">'.$ability_id_ability->name.'</a></td>
        <td>'.$recipe_ability['points_needed'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $recipe->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $recipe->id).'

              '.HTMLHelper::genererInputHidden('ability_id', $ability_id_ability->id).'              '.HTMLHelper::genererButton('action',  'del_recipe_ability', array('type' => 'submit'), 'Supprimer').'
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

  $liste_valeurs_ability = Ability::db_get_select_list();?>
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $recipe->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $recipe->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('ability_id', $liste_valeurs_ability, null, array(), 'Ability' )?><a href="<?php echo get_page_url('admin_ability_mod')?>">Créer un objet Ability</a>
        </p>
        <p class="field">
          <?php echo HTMLHelper::genererInputText('points_needed', null, array(), 'Points Needed*' )?>
          
        </p>
        <p><?php echo HTMLHelper::genererButton('action',  'set_recipe_ability', array('type' => 'submit'), 'Ajouter un élément')?></p>
      </fieldset>
    </form>
    <h4>Recipe Byproduct</h4>
<?php

  $recipe_byproduct_list = $recipe->get_recipe_byproduct_list();

  if(count($recipe_byproduct_list)) {
?>
    <table class="table table-bordered table-condensed table-striped table-striped">
      <thead>
        <tr>
          <th>Item Template</th>
          <th>Quantity</th>          <th>Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="3"><?php echo count( $recipe_byproduct_list )?> lignes</td>
        </tr>
      </tfoot>
      <tbody>
<?php
      foreach( $recipe_byproduct_list as $recipe_byproduct ) {

 
        $item_template_id_item_template = Item_Template::instance( $recipe_byproduct['item_template_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_item_template_view', true, array('id' => $item_template_id_item_template->id)).'">'.$item_template_id_item_template->name.'</a></td>
        <td>'.$recipe_byproduct['quantity'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $recipe->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $recipe->id).'

              '.HTMLHelper::genererInputHidden('item_template_id', $item_template_id_item_template->id).'              '.HTMLHelper::genererButton('action',  'del_recipe_byproduct', array('type' => 'submit'), 'Supprimer').'
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
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $recipe->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $recipe->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('item_template_id', $liste_valeurs_item_template, null, array(), 'Item Template' )?><a href="<?php echo get_page_url('admin_item_template_mod')?>">Créer un objet Item Template</a>
        </p>
        <p class="field">
          <?php echo HTMLHelper::genererInputText('quantity', null, array(), 'Quantity*' )?>
          
        </p>
        <p><?php echo HTMLHelper::genererButton('action',  'set_recipe_byproduct', array('type' => 'submit'), 'Ajouter un élément')?></p>
      </fieldset>
    </form>
    <h4>Recipe Consumable</h4>
<?php

  $recipe_consumable_list = $recipe->get_recipe_consumable_list();

  if(count($recipe_consumable_list)) {
?>
    <table class="table table-bordered table-condensed table-striped table-striped">
      <thead>
        <tr>
          <th>Item Template</th>
          <th>Quantity</th>          <th>Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="3"><?php echo count( $recipe_consumable_list )?> lignes</td>
        </tr>
      </tfoot>
      <tbody>
<?php
      foreach( $recipe_consumable_list as $recipe_consumable ) {

 
        $item_template_id_item_template = Item_Template::instance( $recipe_consumable['item_template_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_item_template_view', true, array('id' => $item_template_id_item_template->id)).'">'.$item_template_id_item_template->name.'</a></td>
        <td>'.$recipe_consumable['quantity'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $recipe->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $recipe->id).'

              '.HTMLHelper::genererInputHidden('item_template_id', $item_template_id_item_template->id).'              '.HTMLHelper::genererButton('action',  'del_recipe_consumable', array('type' => 'submit'), 'Supprimer').'
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
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $recipe->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $recipe->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('item_template_id', $liste_valeurs_item_template, null, array(), 'Item Template' )?><a href="<?php echo get_page_url('admin_item_template_mod')?>">Créer un objet Item Template</a>
        </p>
        <p class="field">
          <?php echo HTMLHelper::genererInputText('quantity', null, array(), 'Quantity*' )?>
          
        </p>
        <p><?php echo HTMLHelper::genererButton('action',  'set_recipe_consumable', array('type' => 'submit'), 'Ajouter un élément')?></p>
      </fieldset>
    </form>
<?php
  // CUSTOM

  //Custom content

  // /CUSTOM
?>
    <p><a href="<?php echo get_page_url('admin_recipe')?>">Revenir à la liste des objets Recipe</a></p>
  </div>
</div>