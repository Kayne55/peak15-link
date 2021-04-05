<?php 
/**
 * @package Peak15Link
 */

 namespace Inc\Base;

 class BaseController 
 {
    public $plugin_path;
    public $plugin_url;
    public $plugin;
    public $beacon_token;

    public function __construct() {
        $this->plugin_path = plugin_dir_path( dirname(__FILE__,  2) );
        $this->plugin_url = plugin_dir_url( dirname(__FILE__,  2) );
        $this->plugin = plugin_basename( dirname(__FILE__,  3) ) . '/peak15-link.php';
        $this->beacon_token = get_option( 'api_token' );
    }
}
