<?php

namespace AcceptPaymentsWPInc\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Installation.
 *
 * Static class that deals with plugin activation and deactivation events.
 */
class Installation {

	/**
	 * What happens when the plugin is activated.
	 */
	public static function activate() {
        flush_rewrite_rules();
	}

	/**
	 * What happens when the plugin is deactivated.
	 */
	public static function deactivate() {
        flush_rewrite_rules();
	}
}
