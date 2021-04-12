<?php

/**
 * Peak15 Link
 *
 * @package           Peak15Link
 * @author            Kayne Jeacocks
 * @copyright         2019 Kayne Jeacocks
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * 
 * Plugin Name:       Peak15 Link
 * Plugin URI:        http://fivefive.co.za/
 * Description:       The Peak15 Link plugin allows you to display your itineraries and departures from your Peak15 Travel CRM on your WordPress frontend as well as allowing your users to send inquiries, make bookings and update their profiles.
 * Version:           0.1.1
 * Author:            Kayne Jeacocks
 * Author URI:        http://fivefive.co.za/
 * Text Domain:       peak15-link
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

// Require once our Composer Autoload file
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// Our code that runs during plugin activation
function activate_peak15link_plugin() {
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_peak15link_plugin' );

// Our code that runs during deactivation
function deactivate_peak15link_plugin() {
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_peak15link_plugin' );

// Here we initialize all of the core classes of our plugin
if ( class_exists( 'Inc\\Init') ) {
    Inc\Init::register_services();
}