<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.templatesplugin.com/
 * @since      1.0.0
 *
 * @package    Vs_Anonymous_Post
 * @subpackage Vs_Anonymous_Post/admin/partials
 */
?>

<?php
$args = array(
    'public'   => true,
    '_builtin' => false
);

$output = 'names'; // names or objects, note names is the default
$operator = 'or'; // 'and' or 'or'

$featureChecked = (get_option('featureImage') == 1) ? 'checked=checked':'';
$categories = (get_option('categories') == 1) ? 'checked=checked':'';

$form ='<div id="wpbody">';

$form .='<div tabindex="0" aria-label="Main content" id="wpbody-content" style="overflow: hidden;">';
$form .='<div class="wrap">';
$form .='<h2>'.__( "Anonymous Post Setup", "vs-anonymous-post" ).'</h2>';
$form .='<form id="form" method="post" action="" name="form">';
$form .='<table  class="form-table">';
$form .='<tbody>';
$form .='<tr>';
$form .='<th scope="row" class="manage-column column-title"><label for="blogname">'.__( "Feature Image", "vs-anonymous-post" ).'</label></th>';

$form .='<td><input type="checkbox" '. $featureChecked .' id="featureImage" name="featureImage" value="1"></td>';
$form .='</tr>';

$form .='<tr>';
$form .='<th scope="row" class="manage-column column-title"><label for="blogname">'.__( "Post Type", "vs-anonymous-post" ).'</label></th>';
$form .='<td>';
$form .='<select name="postType" id="postType">';
$postTypes = get_post_types($args,$output,$operator);
foreach($postTypes as $type){
    $postType= (get_option('postType') ==  $type ) ? 'selected=selected':'';
    $form .='<option '. $postType .' value="'. $type .'">'. ucfirst($type).'</option>';
}
$form .='</select>';
$form .='</td>';
$form .='</tr>';

$form .='<tr>';
$form .='<th scope="row" class="manage-column column-title"><label for="blogname">'.__( "Categories", "vs-anonymous-post" ).'</label></th>';
$form .='<td><input type="checkbox" id="categories" '. $categories .' name="categories" value="1"></td>';
$form .='</tr>';
$form .='<tr>';
$form .='<th scope="row" class="manage-column column-title">&nbsp;</th>';
$form .='<td>';
$form .='<div id="publishing-action">';
$form .='<span class="spinner"></span>';
$form .='<input type="hidden" value="'. wp_create_nonce('vs_form_admin_nonce').'" name="vs_form_admin_nonce"/>';
$form .='<input type="submit" accesskey="p" value="'.__( "Publish", "vs-anonymous-post" ).'" class="button button-primary button-large" id="publish" name="publish"></div>';
$form .='</div>';
$form .='</td>';
$form .='</tr>';
$form .='</tbody>';
$form .='</table>';
$form .='</form>';
$form .='</div></div></div>';

echo $form;

