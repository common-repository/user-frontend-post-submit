<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.templatesplugin.com/
 * @since      1.0.0
 *
 * @package    Vs_Anonymous_Post
 * @subpackage Vs_Anonymous_Post/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vs_Anonymous_Post
 * @subpackage Vs_Anonymous_Post/public
 * @author     templatesplugin <sadidcse8320@gmail.com>
 */
class Vs_Anonymous_Post_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}



	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vs_Anonymous_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vs_Anonymous_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        global $wp_styles, $is_IE;
        wp_enqueue_style( 'prefix-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0' );
        if ( $is_IE ) {
            wp_enqueue_style( 'prefix-font-awesome-ie', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome-ie7.min.css', array('prefix-font-awesome'), '4.3.0' );
            // Add IE conditional tags for IE 7 and older
            $wp_styles->add_data( 'prefix-font-awesome-ie', 'conditional', 'lte IE 7' );
        }
        wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'bootstrap/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap-theme', plugin_dir_url( __FILE__ ) . 'bootstrap/css/bootstrap-theme.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vs-anonymous-post-public.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'cropper-css', plugin_dir_url( __FILE__ ) . 'cropper/css/cropper.css', array(), $this->version, 'all' );


    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vs_Anonymous_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vs_Anonymous_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_script( "jq-validation", plugin_dir_url( __FILE__ ) . 'js/jQuery.validation.1.10.0.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vs-anonymous-post-public.js', array( 'jq-validation' ), $this->version, false );
        wp_enqueue_script( "bootstrap", plugin_dir_url( __FILE__ ) . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "cropper-js", plugin_dir_url( __FILE__ ) . 'cropper/js/cropper.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "custom-select", plugin_dir_url( __FILE__ ) . 'js/custom-select.js', array( 'jquery' ), $this->version, false );

	}


	//grabes the posted form data and save post accordingly
	function handle_form_submission()
	{

		if(isset($_POST['vs_form_nonce']) && wp_verify_nonce($_POST['vs_form_nonce'],'vs_form_nonce'))
		{
			$this->save_post();
		}
	}

	//Shortcode for the form
	function form_short_code()
	{
		include('partials/vs-anonymous-post-public-short-code.php');
		return $form;
	}

	private function save_post()
	{
		$form_post_title = sanitize_text_field($_POST['form_post_title']);
		$form_content = wp_kses_post($_POST['form_content_editor']);

	    $post_type = get_option('postType') !='' ? get_option('postType') : 'post';

        $publish_status = 'draft';
		$author = 1;

        $attach_id = $this->save_feature_image($_FILES['form_post_image']);


		$post_arguments = array('post_type'=> $post_type,
			'post_title'=>$form_post_title,
			'post_content'=>$form_content,
			'post_status'=>$publish_status,
			'post_author'=>$author
		);

		$post_id = wp_insert_post($post_arguments);
		if ($post_id && isset($attach_id) && $attach_id) {
			add_post_meta($post_id, '_thumbnail_id', $attach_id, true);//adding featured image to post
		}
	}

    /**
     * @param $image_input
     * @return int
     */
    private function save_feature_image($image_input)
    {
        if(!isset($image_input['name']) || $image_input['name'] == "") {
            return null;
        }

        $attach_id = null;
        $ext_array = explode('.', $image_input['name']);
        $ext = end($ext_array);
        if (($ext == 'jpeg' || $ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'JPEG' || $ext == 'PNG' || $ext == 'JPG'))//if users upload invalid file type
        {

            if (!function_exists('wp_handle_upload')) require_once(ABSPATH . 'wp-admin/includes/file.php');
            $upload_result = wp_handle_upload($image_input, array('test_form' => false));

            if (!isset($upload_result['error'])) {
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $wp_upload_dir = wp_upload_dir();
                $attachment = array(
                    'guid' => $wp_upload_dir['url'] . '/' . basename($upload_result['file']),
                    'post_mime_type' => $upload_result['type'],
                    'post_title' => preg_replace('/\.[^.]+$/', '', basename($upload_result['file'])),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );

                $attach_id = wp_insert_attachment($attachment, $upload_result['file']);

                $attach_data = wp_generate_attachment_metadata($attach_id, $upload_result['file']);
                wp_update_attachment_metadata($attach_id, $attach_data);
            }

        }

        return $attach_id;
    }


    public function captcha_validation()
    {
        session_start();
        if ($_REQUEST["captcha"] == $_SESSION["vercode"] AND $_SESSION["vercode"] !='')  {
            exit('true');
        } else {
            exit('false');
        };
    }

    public function init_ajax_url(){
        $url = admin_url("admin-ajax.php?action=vs_ap_captcha_validate");
        echo '<script type="text/javascript">';
        echo "var vs_ap_captcha_validate_url = '{$url}'";
        echo '</script>';
    }

}
