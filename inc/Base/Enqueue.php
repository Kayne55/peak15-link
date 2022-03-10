<?php 
/**
 * @package Peak15Link
 */

 namespace Inc\Base;

 use \Inc\Base\BaseController;

 class Enqueue extends BaseController
 {

    public function register() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
    }

    function admin_enqueue() {
        // Enqueue our admin css files
        wp_enqueue_style( 'peak15link-css-admin', $this->plugin_url . 'dist/css/peak15link-admin.min.css' );
        
        // Enqueue our admin script files
        wp_enqueue_script( 'peak15link-js-admin', $this->plugin_url . 'dist/js/peak15link-admin.min.js' );
    }

    function frontend_enqueue() {

        $plugin_data = get_plugin_data( $this->plugin_path . '/peak15-link.php' );
        $version = $plugin_data['Version']; 
        // Enqueue our front-end css files
        wp_enqueue_style( 'peak15link-css-general', $this->plugin_url . 'dist/css/peak15link-general.min.css', array(), $version );

        // Enqueue our admin script files
        wp_enqueue_script( 'peak15link-js-front', $this->plugin_url . 'dist/js/peak15link-frontend.min.js', array(), $version, true );
    }

}