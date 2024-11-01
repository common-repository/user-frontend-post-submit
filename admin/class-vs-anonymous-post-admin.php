<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.templatesplugin.com/
 * @since      1.0.0
 *
 * @package    Vs_Anonymous_Post
 * @subpackage Vs_Anonymous_Post/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vs_Anonymous_Post
 * @subpackage Vs_Anonymous_Post/admin
 * @author     templatesplugin <sadidcse8320@gmail.com>
 */
class Vs_Anonymous_Post_Admin {

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

	private $base_dir;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->base_url = plugin_dir_url(__FILE__);

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, $this->base_url . 'css/vs-anonymous-post-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, $this->base_url . 'js/vs-anonymous-post-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the admin menu.
	 *
	 * @since    1.0.0
	 */
	function add_menu()
	{
		add_menu_page(__('VS Anonymoust Post Settings','vs-anonymous-post'),__('Anonymous Post','vs-anonymous-post'),'manage_options','vs-anonymous-post',array($this,'settings'));
	}

	function settings()
	{
        if(isset($_POST['vs_form_admin_nonce']) && wp_verify_nonce($_POST['vs_form_admin_nonce'],'vs_form_admin_nonce'))
        {
            $this->save_admin_post();
        }
        include_once('partials/vs-anonymous-post-admin-display.php');
	}


    function save_admin_post()
    {
        $featureImage = isset($_REQUEST['featureImage'] ) ? 1:0;
        $postType = isset($_REQUEST['postType'] ) ? $_REQUEST['postType'] :0;
        $categories = isset($_REQUEST['categories'] ) ? 1:0;
        $tags = isset($_REQUEST['tags'] ) ? 1:0;
        $photoGalleries = isset($_REQUEST['photoGalleries'] ) ? 1:0;
        $galleryCaption= isset($_REQUEST['galleryCaption'] ) ? 1:0;
        update_option( 'featureImage', $featureImage);
        update_option( 'postType', $postType);
        update_option( 'categories', $categories);
        update_option( 'tags', $tags);
        update_option( 'photoGalleries', $photoGalleries);
        update_option( 'galleryCaption', $galleryCaption);

    }


}
