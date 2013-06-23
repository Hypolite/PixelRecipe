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
      $item_type_list = Item_Type::db_get_all();
      foreach( $item_type_list as $item_type)
        $option_list[ $item_type->id ] = $item_type->name;
?>
      <p class="field">
        <span class="libelle">Type Id</span>
        <span class="value"><a href="<?php echo get_page_url('admin_item_type_view', true, array('id' => $item_template->type_id ) )?>"><?php echo $option_list[ $item_template->type_id ]?></a></span>
      </p>
    </div>
    <p><a href="<?php echo get_page_url('admin_item_template_mod', true, array('id' => $item_template->id))?>">Modifier cet objet Item Template</a></p>
    <h4>Recipe Byproduct</h4>
<?php

  $recipe_byproduct_list = $item_template->get_recipe_byproduct_list();

  if(count($recipe_byproduct_list)) {
?>
    <table>
      <thead>
        <tr>
          <th>Recipe Id</th>
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
    <table>
      <thead>
        <tr>
          <th>Recipe Id</th>
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
    <h4>Recipe Tool</h4>
<?php

  $recipe_tool_list = $item_template->get_recipe_tool_list();

  if(count($recipe_tool_list)) {
?>
    <table>
      <thead>
        <tr>
          <th>Recipe Id</th>          <th>Action</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="2"><?php echo count( $recipe_tool_list )?> lignes</td>
        </tr>
      </tfoot>
      <tbody>
<?php
      foreach( $recipe_tool_list as $recipe_tool ) {

 
        $recipe_id_recipe = Recipe::instance( $recipe_tool['recipe_id'] );        echo '
        <tr>
        <td><a href="'.get_page_url('admin_recipe_view', true, array('id' => $recipe_id_recipe->id)).'">'.$recipe_id_recipe->name.'</a></td>          <td>
            <form action="'.get_page_url(PAGE_CODE, true, array('id' => $item_template->id)).'" method="post">
              '.HTMLHelper::genererInputHidden('id', $item_template->id).'

              '.HTMLHelper::genererInputHidden('recipe_id', $recipe_id_recipe->id).'              '.HTMLHelper::genererButton('action',  'del_recipe_tool', array('type' => 'submit'), 'Supprimer').'
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
        <p><?php echo HTMLHelper::genererButton('action',  'set_recipe_tool', array('type' => 'submit'), 'Ajouter un élément')?></p>
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