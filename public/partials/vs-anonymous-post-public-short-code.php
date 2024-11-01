<?php
defined('ABSPATH') or die("No script kiddies please!");

$form ='<div class="ap-form-wrapper">';

global $error;

/**
 * For grabbing the html of the nonce field
 * */

$termArgs = array(
    	'type'                     => 'post',
	'child_of'                 => 0,
	'parent'                   => '',
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 0,
	'hierarchical'             => 1,
	'exclude'                  => '',
	'include'                  => '',
	'number'                   => '',
	'taxonomy'                 => 'category',
	'pad_counts'               => false,
);


$form ='<form method="post" action="" enctype="multipart/form-data" id="anonymous-form" class="form-wrapper">';


$form .='<div class="control-group">';
$form .='<label class="control-label" >'.__( "Title", "vs-anonymous-post" ).'<span class="required">*</span></label>';
$form .='<div class="controls">';
$form .='<input type="text" name="form_post_title" id="form_post_title" placeholder="'.__( "Title", "vs-anonymous-post" ).'" class="form-control"/>';
$form .='</div>';
$form .='</div>';

$form .='<div class="control-group">';
$form .='<label class="control-label" >'.__( "Body", "vs-anonymous-post" ).'<span class="required">*</span></label>';
$form .='<div class="controls">';
$form .='<textarea name="form_content_editor" id="form_content_editor"  class="form-control" rows="5"></textarea>';
$form .='</div>';
$form .='</div>';

$form .='<div class="control-group">';
$form .='<div class="input-prepend input-append">';
$form .='<span class="add-on"><img class="captcha" src="'.plugin_dir_url( __FILE__ ).'captcha.php"></span><input  class="input-medium" type="text" id="captcha" name="captcha" placeholder="Captcha" >';
$form .='</div>';
$form .='</div>';

if(get_option('categories') == 1 && get_option('postType') != 'page' ){

    $form .='<div class="control-group">';
    $form .='<label class="control-label" >'.__( "Category", "vs-anonymous-post" ).'</label>';
    $form .='<div class="controls">';
    $form .='<select name="categories" class="span3">';
    $categories = get_categories( $termArgs );
    foreach ( $categories as $category ) :
        $form .='<option value="' . $category->term_id . '">' . $category->name . '</option>';
    endforeach;
    $form .='</select>';
    $form .='</div>';
    $form .='</div>';

}
if(get_option('featureImage') == 1){


$form .='<div class="control-group">';
$form .='<label class="control-label" >'.__( "Feature Image", "vs-anonymous-post" ).'</label>';
$form .='<div class="controls">';
$form .='<input type="file" name="form_post_image"/>';
$form .='</div>';
$form .='</div>';
}


$form .='<input type="submit" value="'.__( "Submit", "vs-anonymous-post" ).'">';

$form .='<input type="hidden" value="'.wp_create_nonce('vs_form_nonce').'" name="vs_form_nonce"/>';
$form .= '</form>';
$form .='</div><!--ap-form-->';
?>

