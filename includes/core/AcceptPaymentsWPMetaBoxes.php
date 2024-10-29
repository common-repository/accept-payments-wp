<?php

/**
 * @package  Accept Payments WP
 */

namespace AcceptPaymentsWPInc\Core;

class AcceptPaymentsWPMetaBoxes extends AcceptPaymentsWPBaseController
{
    public function buildPaymentFormSettingsMetaBox($value, $ID)
    {

      $value = $this->performMetaBoxDisplayChecks($value);
      echo($value);

      ?>

      <div class="acwp-newform-table">
        <label class="acwp-label" for='price_field'>Item Price</label>
        <div class="input-wrapper">
          <input type='text' id='price_field' name='price_field' value="<?php echo esc_attr( $value['price'] ); ?>">
          <text class="acwp-explanation-nf">The amount is in the currency that your Braintree Account is set and that you indicated in the Settings page of this plugin.</text>
          <br>
        </div>
      </div>

      <div class="acwp-newform-table">
        <label class="acwp-label" for='item_description'>Item Description</label>
        <div class="input-wrapper">
          <input type='text' size="50" id='item_description' name='item_description' value="<?php echo esc_attr( $value['item_description'] ); ?>">
          <text class="acwp-explanation-nf">This will be visible to you only</text>
          <br>
        </div>
      </div>


      <div class="acwp-newform-table">
        <label class="acwp-label" for='button_text'>Payment Button Text</label>
        <div class="input-wrapper">
          <input type='text' size="30" id='button_text' name='button_text' value="<?php echo esc_attr( $value['button_text'] ); ?>">
          <text class="acwp-explanation-nf">This is the text that customers will see on the button below the payment form. Type in {amount} to display the amount to be paid</text>
          <br>
        </div>
      </div>


      <div class="acwp-newform-table">
        <label class="acwp-label" for='success_page_url'>Success Page URL</label>
        <div class="input-wrapper">
          <input size="30" type='text' id='success_page_url' name='success_page_url' value="<?php echo esc_attr( $value['success_page_url'] ); ?>">
          <text class="acwp-explanation-nf">Specify page to which you want the customer to be redirected upon a successful payment</text>
          <br>
        </div>
      </div>

      <div class="acwp-newform-table">
        <label class="acwp-label" for='failure_page_url'>Failure Page URL</label>
        <div class="input-wrapper">
          <input size="30" type='text' id='failure_page_url' name='failure_page_url' value="<?php echo esc_attr( $value['failure_page_url'] ); ?>">
          <text class="acwp-explanation-nf">Specify page to which you want the customer to be redirected upon a failed payment</text>
          <br>
        </div>
      </div>

      <div class="acwp-newform-table">
        <label class="acwp-label" for='post_shortcode'>Shortcode</label>
        <div class="input-wrapper">
          <input size="30" type='text' name='post_shortcode' value="[accept-payments id=<?php echo $ID; ?>]" readonly/>
          <text class="acwp-explanation-nf">Copy and paste this shortcode to your website as simple text in order to render the payment form upon a page load</text>
          <br>
        </div>
      </div>

      <?php

    }

    

    public function performMetaBoxDisplayChecks($value)
    {
      if (! isset($value['price']) ) {
        $value['price'] = "";
      }

      if (! isset($value['description']) ) {
        $value['description'] = "";
      }

      if (! isset($value['success_page_url']) ) {
        if (!get_option( 'success_page' )) {
          $value['success_page_url'] = "";
        } else {
          $value['success_page_url'] = esc_attr( get_option( 'success_page' ) );
        }
      }

      if (! isset($value['failure_page_url']) ) {
        if (!get_option( 'failure_page' )) {
          $value['failure_page_url'] = "";
        } else {
          $value['failure_page_url'] = esc_attr( get_option( 'failure_page' ) );
        }
      }

      if (! isset($value['button_text']) ) {
        $value['button_text'] = "Pay {amount}";
      }

      return $value;
    }
}
