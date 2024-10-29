<?php

/**
 * @package  Accept Payments WP
 */

namespace AcceptPaymentsWPInc\Core;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AcceptPaymentsWPBaseController
{
  public $plugin_name;
  public $plugin;
	public $plugin_path;
	public $plugin_url;
	public $plugin_assets;

	public function __construct()
  {

    $this->plugin = ACCEPT_PAYMENTS_PLUGIN;
	  $this->plugin_name = ACCEPT_PAYMENTS_PLUGIN_NAME;
		$this->plugin_path = ACCEPT_PAYMENTS_PATH;
    $this ->plugin_url = ACCEPT_PAYMENTS_URL;
    $this->plugin_assets = ACCEPT_PAYMENTS_ASSETS;

	}
}
