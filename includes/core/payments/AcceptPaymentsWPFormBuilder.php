<?php

/**
 * @package  Accept Payments WP
 */

namespace AcceptPaymentsWPInc\Core\Payments;


class AcceptPaymentsWPFormBuilder
{
  public $price;
  public $button_text;
  public $bt_price_formatted;
  public $currency_map = array(
    'EUR' => '€',
    'USD' => '$'
  );
  public $test_mode;

  public function __construct($args, $test_mode_input)
  {
    $this->price = $this->format_price($args['price']);
    $this->bt_price_formatted=$this->bt_price_format($args['price']);
    $this->button_text = $this->set_button_text($args['button_text'], $this->price);
    $this->test_mode = $test_mode_input;
  }

  private function format_price($price)
  {
    $price = esc_attr( $price );
    $sep_option = esc_attr( get_option('acwp_format') );

    // Normalize formatting to "."
    $price = str_replace("," , ".", $price);

    // If . is included
    if ( strpos($price, '.') !== false ) {

      $format_diff = strlen($price) - strpos($price, '.') - 1;
      $sep_pos = strpos($price, '.');

       // If correct
      if ( $format_diff == 2 ) {
        return $price;
      }
      // If too many digits after comma
      else if ($format_diff > 2) {
        $remainder = ( mb_substr( mb_substr($price, $sep_pos+1, $sep_pos + 3) , 0, 2));
        return (mb_substr($price, 0, $sep_pos) . $sep_option . $remainder );
      }
      // If too little digits after coma
      else if ($format_diff < 2) {
        $remainder_length = strlen(( mb_substr( mb_substr($price, $sep_pos+1, $sep_pos + 3) , 0, 2)));
        while ($remainder_length < 2) {
          $price = $price . "0";
          $remainder_length = $remainder_length + 1;
        }
        return $price;
      }
    } else {
      return ($price . $sep_option . "00");
    }
  }

  private function bt_price_format($price) {
    $price = str_replace("," , ".", $price);
    return $price;
  }

  private function set_button_text($button_text, $price)
  {
    $button_text = esc_attr( $button_text );
    if (strpos($button_text, '{amount}') !== false) {
      $button_text = mb_substr($button_text, 0, strpos($button_text, '{amount}')) .$this->currency_map[esc_attr( get_option('acwp_currency') )] . $price;
    }

    return $button_text;
  }

  public function build_form()
  {
    $test_mode_text = '<text class="acwp-test-mode-notice">You are in a test mode. <a href="https://medium.com/@AcceptPaymentsWP/accept-payments-wp-test-mode-explained-223b4cfaf972">Learn More</a></text>';
    ?>
    <form id="payment-form" action="/" method="post" data-url="<?php echo admin_url( 'admin-ajax.php'); ?>">
      <div id="dropin-container"></div>
      <?php
      echo '<input id="submit-button" class="accept-payments-wp-button" type="submit" value="'.$this->button_text.'">'.($this->test_mode ? $test_mode_text : '').'</input>';
      echo '<input type="hidden" name ="price" value="'.$this->bt_price_formatted.'"</input>';
      ?>
      <input type="hidden" id="nonce" name="payment_method_nonce"></input>
      <input type="hidden" name="action" value="accept_payments_wp_proccess_nonce"></input>
    </form>

    <?php
  }


}
