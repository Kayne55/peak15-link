<?php 
/**
 * @package Peak15Link
 */

 namespace Inc\Base;

 use \Inc\Base\BaseController;

 class TourFeedCPT extends BaseController
 {

   /**
    * Set Up the API Call
    * 
   */

   // Set our variables including the URL to our Custom API Call and our Custom API process token.
   //https://data.peak15systems.com/beacon/service.svc/get/rideexpeditions/complextext/downloadtransactions?
   public $url;
   public $process_token;
   public $response;

   public function get_api_data()
      {

         

      }
   

    // public function register()
    // {
    //     add_action( 'init', array( $this, 'activate' ) );
    // }

    // public function activate()
    // {
    //     // Register our Custom Post Types
    //     function tour_custom_post_type()
    //     {
    //         $labels = array(
    //             'name'                      => 'Tours',
    //             'singular_name'             => 'Tour',
    //             'add_new'                   => 'New Tour',
    //             'add_new_item'              => 'Add New Tour',
    //             'edit_item'                 => 'Edit Tour',
    //             'new_item'                  => 'New Tour',
    //             'view_item'                 => 'View Tour',
    //             'view_items'                => 'View Tours',
    //             'search_items'              => 'Search Tours',
    //             'not_found'                 => 'No tours found',
    //             'not_found_in_trash'        => 'No tours found in trash',
    //             'all_items'                 => 'All Tours',
    //             'archives'                  => 'Tour Archives',
    //             'attributes'                => 'Tour Attributes',
    //             'insert_into_item'          => 'Insert into tour',
    //             'uploaded_to_this_item'     => 'Uploaded to this tour',
    //             'filter_items_list'         => 'Filter tours list',
    //             'items_list_navigation'     => 'Tours list navigation',
    //             'items_list'                => 'Tours List',
    //             'item_published'            => 'Tour Published',
    //             'item_published_privately'  => 'Tour Published Privately',
    //             'item_reverted_to_draft'    => 'Tour reverted to draft',
    //             'item_scheduled'            => 'Tour Scheduled',     
    //             'item_updated'              => 'Tour Updated'
    //         );

    //         $args = array(
    //             'labels'        => $labels,
    //             'public'        => true,
    //             'has_archive'   => true,
    //             'rewrite'       => array( 'slug' => 'motorcycle-tours' ),
    //             'supports'      => array ( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
    //             'can_export'    => true,
    //             'menu_icon'     => 'https://www.rideexpeditions.com/motorcycle-tours/rx-dirtbike-icon-01/'
    //         );

    //         register_post_type( 'p15_tours', $args );
    //     }

    //     tour_custom_post_type();

    //     // Register our Custom Taxonomies
    //     function tour_custom_taxonomies()
    //     {
    //         $labels = array(
    //             'name'              => 'Destinations',
    //             'singular_name'     => 'Destination',
    //             'search_items'      => 'Search Destinations',
    //             'all_items'         => 'All Destinations',
    //             'parent_item'       => 'Parent Destination',
    //             'parent_item_colon' => 'Parent Destination:',
    //             'edit_item'         => 'Edit Destination',
    //             'view_item'         => 'View Destination',
    //             'update_item'       => 'Update Destination',
    //             'add_new_item'      => 'Add New Destination',
    //             'new_item_name'     => 'New Destination Name',
    //             'not_found'         => 'No destinations found',
    //             'no_terms'          => 'No Destinations',
    //             'filter_by_item'    => 'Filter by destination',
    //         );

    //         $args = array(
    //             'labels'            => $labels,
    //             'public'            => true,
    //             'hierarchical'      => true,
    //             'show_ui'           => true,
    //             'show_in_menu'      => true,
    //             'show_admin_column' => true,
    //             'rewrite'           => array( 'slug' => 'destination' )
    //         );

    //         register_taxonomy( 'destination', array('p15_tours'), $args );
    //     }

    //     tour_custom_taxonomies();

    //     // Register our Custom Tags
    //     function tour_custom_tags()
    //     {
    //         $labels = array(
    //             'name'              => 'Activity Types',
    //             'singular_name'     => 'Activity Type',
    //             'search_items'      => 'Search Activity Types',
    //             'all_items'         => 'All Activity Types',
    //             'parent_item'       => 'Parent Activity Type',
    //             'parent_item_colon' => 'Parent Activity Type:',
    //             'edit_item'         => 'Edit Activity Type',
    //             'view_item'         => 'View Activity Type',
    //             'update_item'       => 'Update Activity Type',
    //             'add_new_item'      => 'Add New Activity Type',
    //             'new_item_name'     => 'New Activity Type Name',
    //             'not_found'         => 'No activity types found',
    //             'no_terms'          => 'No Activity Types',
    //             'filter_by_item'    => 'Filter by activity type',
    //         );

    //         $args = array(
    //             'labels'            => $labels,
    //             'rewrite'           => array('slug' => 'activity-type'),
    //             'hierarchical'      => false,
    //             'show_admin_column' => true
    //         );

    //         register_taxonomy( 'activity', array('p15_tours'), $args );
    //     }

    //     tour_custom_tags();

    // }
 }