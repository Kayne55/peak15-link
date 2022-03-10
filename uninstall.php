<?php

/**
 * Trigger this file on plugin uninstall
 * 
 * @package Peak15Link
 */

 if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
     die;
 }

 // Access the database via SQL and Delete the plugin data stored in the Database
 global $wpdb;
 $wpdb->query( "DELETE FROM {$wpdb->prefix}posts WHERE post_type = 'peak15-link'" );
 $wpdb->query( "DELETE FROM {$wpdb->prefix}postmeta WHERE post_id NOT IN (SELECT id FROM {$wpdb->prefix}posts)" );
 $wpdb->query( "DELETE FROM {$wpdb->prefix}term_relationships WHERE object_id NOT IN (SELECT id FROM {$wpdb->prefix}posts)" );