<?php

/**
 * @package  Accept Payments WP
 */

namespace AcceptPaymentsWPInc\Core;

class AcceptPaymentsWPAssets extends AcceptPaymentsWPBaseController
{
    public function register() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    }

    public function enqueue() {
      // Plugin
      wp_enqueue_style( 'accept_payments_wp_styles', $this->plugin_url . 'assets/css/accept_payments_wp_styles.css' );
      wp_enqueue_style( 'accept_payments_wp_dashicon', $this->plugin_url . 'assets/css/accept-payments-wp.css' );
      wp_enqueue_script( 'accept_payments_wp_script', $this->plugin_url . 'assets/js/accept_payments_wp_script.js' );
    }
}
