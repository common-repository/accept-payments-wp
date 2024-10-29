<?php

/**
 * @package  Accept Payments WP
 */

namespace AcceptPaymentsWPInc\Core\Payments;

use Braintree\Gateway;

class BraintreeAPI
{
  public $gateway;

  public function __construct()
  {
    if (get_option('test_mode') == "1") {
      # Handle test mode
      $environment = 'sandbox';
      $merchantId = '677zwb6jwpr6mr2h';
      $publicKey = 'p9pysxthydsdrmyv';
      $privateKey = 'bc002ed170dbe43cd0d6e65723112e98';
    } else {
      # Handle live mode
      $merchantId = esc_attr( get_option( 'merchant_id' ) );
      $publicKey = esc_attr( get_option( 'public_key' ) );
      $privateKey = esc_attr( get_option( 'private_key' ) );
      # Figure out if sandbox or production

      if ( strpos( esc_attr( get_option( 'tokenization_key' ) ), 'sandbox' ) !== false ) {
        $environment = 'sandbox';
      } else {
        $environment = 'production';
      }

    }
    $this -> gateway = new Gateway([
      'environment' => $environment,
      'merchantId' => $merchantId,
      'publicKey' => $publicKey,
      'privateKey' => $privateKey
    ]);

  }

}
