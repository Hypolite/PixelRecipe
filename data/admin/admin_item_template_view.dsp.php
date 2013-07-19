<?php

  $tab_visible = array('0' => 'Non', '1' => 'Oui');

  $form_url = get_page_url(PAGE_CODE).'&id='.$item_template->id;
  $PAGE_TITRE = 'Item Template : Showing "'.$item_template->name.'"';
?>
<div class="texte_contenu">
  <div class="texte_texte">
    <h3>Showing "<?php echo $item_template->name?>"</h3>
    <div class="informations formulaire">

            <p class="field">
              <span class="libelle">Tech</span>
              <span class="value"><?php echo is_array($item_template->tech)?nl2br(parameters_to_string( $item_template->tech )):$item_template->tech?></span>
            </p>
<?php
      $option_list = array();
      $sub_item_type_list = Item_Type::db_get_all();
      foreach( $sub_item_type_list as $sub_item_type)
        $option_list[ $sub_item_type->id ] = $sub_item_type->name;
?>
      <p class="field">
        <span class="libelle">Type Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_item_type_view', true, array('id' => $item_template->type_id ) )?>"><?php echo $option_list[ $item_template->type_id ]?></a></span>
      </p>

            <p class="field">
              <span class="libelle">Obsolete</span>
              <span class="value"><?php echo is_array($item_template->obsolete)?nl2br(parameters_to_string( $item_template->obsolete )):$item_template->obsolete?></span>
            </p>
<?php
      $option_list = array(null => 'Pas de choix');
      $sub_item_template_list = Item_Template::db_get_all();
      foreach( $sub_item_template_list as $sub_item_template)
        $option_list[ $sub_item_template->id ] = $sub_item_template->name;
?>
      <p class="field">
        <span class="libelle">Next Item Template Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_item_template_view', true, array('id' => $item_template->next_item_template_id ) )?>"><?php echo $option_list[ $item_template->next_item_template_id ]?></a></span>
      </p>
    </div>
    <p><a href="<?php echo get_page_url('admin_item_template_mod', true, array('id' => $item_template->id))?>">Modifier cet objet Item Template</a></p>
    <h4>Item Template Ability</h4>
<?php

  $item_template_ability_list = $item_template->get_item_template_ability_list();

  if(count($item_template_ability_list)) {
?>
    <table class="table table-bordered table-condensed table-striped table-striped">
      <thead>
        <tr>
          <th>Ability</th>
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

 
        $ability_id_ability = Ability::instance( $item_template_ability['ability_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_ability_view', true, array('id' => $ability_id_ability->id)).'">'.$ability_id_ability->name.'</a></td>
        <td>'.$item_template_ability['points_provided'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $item_template->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $item_template->id).'

              '.HTMLHelper::genererInputHidden('ability_id', $ability_id_ability->id).'              '.HTMLHelper::genererButton('action',  'del_item_template_ability', array('type' => 'submit'), 'Supprimer').'
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
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $item_template->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $item_template->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('ability_id', $liste_valeurs_ability, null, array(), 'Ability' )?><a href="<?php echo get_page_url('admin_ability_mod')?>">Créer un objet Ability</a>
        </p>
        <p class="field">
          <?php echo HTMLHelper::genererInputText('points_provided', null, array(), 'Points Provided*' )?>
          
        </p>
        <p><?php echo HTMLHelper::genererButton('action',  'set_item_template_ability', array('type' => 'submit'), 'Ajouter un élément')?></p>
      </fieldset>
    </form>
    <h4>Recipe Byproduct</h4>
<?php

  $recipe_byproduct_list = $item_template->get_recipe_byproduct_list();

  if(count($recipe_byproduct_list)) {
?>
    <table class="table table-bordered table-condensed table-striped table-striped">
      <thead>
        <tr>
          <th>Recipe</th>
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

 
        $recipe_id_recipe = Recipe::instance( $recipe_byproduct['recipe_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_recipe_view', true, array('id' => $recipe_id_recipe->id)).'">'.$recipe_id_recipe->name.'</a></td>
        <td>'.$recipe_byproduct['quantity'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $item_template->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $item_template->id).'

              '.HTMLHelper::genererInputHidden('recipe_id', $recipe_id_recipe->id).'              '.HTMLHelper::genererButton('action',  'del_recipe_byproduct', array('type' => 'submit'), 'Supprimer').'
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

  $liste_valeurs_recipe = Recipe::db_get_select_list();?>
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $item_template->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $item_template->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('recipe_id', $liste_valeurs_recipe, null, array(), 'Recipe' )?><a href="<?php echo get_page_url('admin_recipe_mod')?>">Créer un objet Recipe</a>
        </p>
        <p class="field">
          <?php echo HTMLHelper::genererInputText('quantity', null, array(), 'Quantity*' )?>
          
        </p>
        <p><?php echo HTMLHelper::genererButton('action',  'set_recipe_byproduct', array('type' => 'submit'), 'Ajouter un élément')?></p>
      </fieldset>
    </form>
    <h4>Recipe Consumable</h4>
<?php

  $recipe_consumable_list = $item_template->get_recipe_consumable_list();

  if(count($recipe_consumable_list)) {
?>
    <table class="table table-bordered table-condensed table-striped table-striped">
      <thead>
        <tr>
          <th>Recipe</th>
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

 
        $recipe_id_recipe = Recipe::instance( $recipe_consumable['recipe_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_recipe_view', true, array('id' => $recipe_id_recipe->id)).'">'.$recipe_id_recipe->name.'</a></td>
        <td>'.$recipe_consumable['quantity'].'</td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $item_template->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $item_template->id).'

              '.HTMLHelper::genererInputHidden('recipe_id', $recipe_id_recipe->id).'              '.HTMLHelper::genererButton('action',  'del_recipe_consumable', array('type' => 'submit'), 'Supprimer').'
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

  $liste_valeurs_recipe = Recipe::db_get_select_list();?>
    <form action="<?php echo get_page_url(PAGE_CODE, true, array('id' => $item_template->id))?>" method="post" class="formulaire">
      <?php echo HTMLHelper::genererInputHidden('id', $item_template->id )?>
      <fieldset>
        <legend>Ajouter un élément</legend>
        <p class="field">
          <?php echo HTMLHelper::genererSelect('recipe_id', $liste_valeurs_recipe, null, array(), 'Recipe' )?><a href="<?php echo get_page_url('admin_recipe_mod')?>">Créer un objet Recipe</a>
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
    <p><a href="<?php echo get_page_url('admin_item_template')?>">Revenir à la liste des objets Item Template</a></p>
  </div>
</div>