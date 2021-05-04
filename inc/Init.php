<?php
/**
 * @package Peak15Link
 */

namespace Inc;

final class Init 
{
    /**
     * We store all our classes inside an array
     * @return array Our list of classes
     */
    public static function get_services()
    {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            //Base\TourFeedCPT::class,
            Base\BookingController::class,
            Base\AjaxFormsController::class,
        ];
    }
  
    /**
     * Here we loop through and inititalize our classes
     * and call the register() method if it exists
     * @return
     */
    public static function register_services() {
        foreach ( self::get_services() as $class ) {
            $service = self::instantiate( $class );
            if ( method_exists( $service, 'register' ) ) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     * @param class $class      Our class from the services array
     * @return class instance   A new instance of the class
     */
    private static function instantiate( $class )
    {
        $service = new $class();

        return $service;
    }

}

// use Inc\Activate;
// use Inc\Deactivate;
// use Inc\Admin\AdminPages;

// if ( !class_exists( 'Peak15Link' ) ) {

//     class Peak15Link
//     {

//         public $plugin;

//         function __construct() {
//             $this->plugin = plugin_basename( __FILE__ );
//         }

//         function register() {
//             add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
            
//             add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
            
//             add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
//         }

//         public function settings_link( $links ) {
//             $settings_link = '<a href="admin.php?page=peak15_link">Settings</a>';
//             array_push( $links, $settings_link );
//             return $links;
//         }

//         public function add_admin_pages() {
//             add_menu_page( 'Peak15 Link Plugin', 'Peak15 Link', 'manage_options', 'peak15_link', array( $this, 'admin_index' ), 'dashicons-palmtree', 25 );
//         }

//         public function admin_index() {
//             require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
//         }

//         protected function create_post_type() {
//             add_action( 'init', array( $this, 'custom_post_type' ) );
//         }

//         function custom_post_type() {
//             register_post_type( 'peak15-link', [ 'public' => true, 'label' => 'Peak15 Link'] );
//         }

//         function enqueue() {
//             // Enqueue all our scripts
//             wp_enqueue_style( 'peak15linkcss', plugins_url( '/assets/css/peak15link-admin.css', __FILE__ ) );
//             wp_enqueue_script( 'peak15linkjs', plugins_url( '/assets/js/peak15link-admin.js', __FILE__ ) );
//         }

//         function activate() {
//             Activate::activate();
//         }
//     }

//     $peak15Link = new Peak15Link();
//     $peak15Link->register();

// // Activation
// register_activation_hook( __FILE__, array( $peak15Link, 'activate' ) );

// // Deactivation
// register_deactivation_hook( __FILE__, array( 'Deactivate', 'deactivate' ) );

// }