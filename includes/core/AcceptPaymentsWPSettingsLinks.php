<?php

/**
 * @package  Accept Payments WP
 */

namespace AcceptPaymentsWPInc\Core;

class AcceptPaymentsWPSettingsLinks extends AcceptPaymentsWPBaseController
{
	public function register()
	{
		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
	}

	public function settings_link( $links )
	{
		$settings_link = '<a href="admin.php?page=' . $this->plugin_name . '_main">Settings</a>';

		array_push( $links, $settings_link );

		return $links;
	}
}
