<?php

/**
 * Plugin Name: Accept Payments WP
 * Plugin URI:  https://www.acceptpaymentswp.com
 * Description: Easily accept Braintree Payments on your Wordpress website
 * Author: Lukas Paskauskas
 * Version: 1.2.1
 * Text Domain: accept-payments-wp
 */

/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright 2019 AcceptPaymentsWP. All rights reserved.
 */


 if ( ! defined( 'ABSPATH' ) ) {
     exit;
 }


if ( ! defined( 'ACCEPT_PAYMENTS_VERSION' ) ) {

  define( 'ACCEPT_PAYMENTS_VERSION', '1.0.0' );

  if ( ! defined( 'ACCEPT_PAYMENTS_PLUGIN_NAME' ) ) {
		define( 'ACCEPT_PAYMENTS_PLUGIN_NAME', 'accept_payments_wp' );
	}

  if ( ! defined( 'ACCEPT_PAYMENTS_URL' ) ) {
      define('ACCEPT_PAYMENTS_URL', plugin_dir_url( __FILE__ ));
  }

  if ( ! defined( 'ACCEPT_PAYMENTS_PLUGIN' ) ) {
      define('ACCEPT_PAYMENTS_PLUGIN', plugin_dir_url( __FILE__ ) . '/accept-payments-wp.php');
  }

  if ( ! defined( 'ACCEPT_PAYMENTS_PATH' ) ) {
      define('ACCEPT_PAYMENTS_PATH', plugin_dir_path( __FILE__ ));
  }

  if ( ! defined( 'ACCEPT_PAYMENTS_ASSETS' ) ) {
      define('ACCEPT_PAYMENTS_ASSETS', ACCEPT_PAYMENTS_URL . 'assets/');
  }

}

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

require_once dirname( __FILE__ ) . '/includes/Init.php';

/**
 * The code that runs during plugin activation
 */
function activate_accept_payments_wp_plugin() {
	AcceptPaymentsWPInc\Core\Installation::activate();
}
register_activation_hook( __FILE__, 'activate_accept_payments_wp_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_accept_payments_wp_plugin() {
    AcceptPaymentsWPInc\Core\Installation::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_wp_plugin' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'AcceptPaymentsWPInc\\Init' ) ) {
	AcceptPaymentsWPInc\Init::register_services();
}
