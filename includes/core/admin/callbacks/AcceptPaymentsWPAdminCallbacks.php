<?php

namespace AcceptPaymentsWPInc\Core\Admin\Callbacks;

use AcceptPaymentsWPInc\Core\AcceptPaymentsWPBaseController;

class AcceptPaymentsWPAdminCallbacks extends AcceptPaymentsWPBaseController
{

	public function adminSettings()
	{
		return require_once( $this->plugin_path . 'templates/admin/settings.php' );
	}

	public function adminSupport()
	{
		return require_once( $this->plugin_path . 'templates/admin/support.php' );
	}

	// callbacks for options
    public function ourAdminOptionsGroup( $input )
    {
        return $input;
    }

		public function textValidator( $input )
    {
  		return $input;
    }

		public function checkboxValidator( $input )
    {
  		return $input;
    }

		public function urlValidator( $input )
    {
  		return $input;
    }

		public function currencyValidator( $input )
    {
        return $input;
    }

		public function formatValidator( $input )
    {
        return $input;
    }

    public function settingsSection()
    {
				return;
    }

		public function testMode()
    {
        $value = get_option( 'test_mode' );

				if ($value == "1") {
					$value = true;
				} else {
					$value = false;
				}
				echo '<input type="checkbox" value="1" name="test_mode" ' . ($value ? 'checked' : '') . '>';
		}

		public function merchantID()
    {
        $value = esc_attr( get_option( 'merchant_id' ) );
				$strlen = strlen($value) + 5;
				if ($strlen < 20) {
					$strlen = 20;
				}
				echo '<input type="text" class="acwp-settings-text" name="merchant_id" value="' . $value . '" placeholder=" " size="'. $strlen . '"><br>';

    }

		public function publicKey()
    {
        $value = esc_attr( get_option( 'public_key' ) );
				$strlen = strlen($value) + 5;
				if ($strlen < 20) {
					$strlen = 20;
				}
				echo '<input type="text" class="acwp-settings-text" name="public_key" value="' . $value . '" placeholder=" " size="'. $strlen . '"><br>';

    }

		public function privateKey()
    {
        $value = esc_attr( get_option( 'private_key' ) );
				$strlen = strlen($value) + 5;
				if ($strlen < 20) {
					$strlen = 20;
				}
				echo '<input type="text" class="acwp-settings-text" name="private_key" value="' . $value . '" placeholder=" " size="'. $strlen . '"><br>';

    }

    public function tokenizationKey()
    {
        $value = esc_attr( get_option( 'tokenization_key' ) );
				$strlen = strlen($value) + 5;
				if ($strlen < 20) {
					$strlen = 20;
				}
        echo '<input type="text" class="acwp-settings-text" name="tokenization_key" value="' . $value . '" placeholder=" " size="'. $strlen . '"><br>';
    }

		public function acwpCurrency()
    {
				$value = esc_attr( get_option( 'acwp_currency' ) );

				if ($value == "EUR"){
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_currency" value="EUR" checked>EUR - €</label><br>';
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_currency" value="USD">USD - $</label><br>';
				} elseif ($value == "USD") {
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_currency" value="EUR">EUR - €</label><br>';
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_currency" value="USD" checked>USD - $</label><br>';
				} else {
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_currency" value="EUR" checked>EUR - €</label><br>';
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_currency" value="USD">USD - $</label><br>';
				}

				echo '<p class="acwp-explanation">Mark what currency you want to be displayed on your payment forms. We recommend to select the same currency as your Braintree Account is set in.</p>';
		}

		public function acwpFormat()
    {
				$value = esc_attr( get_option( 'acwp_format' ) );

				if ($value == ","){
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_format" value="," checked>Comma (example: $12,54)</label><br>';
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_format" value=".">Dot (example: $12.54)</label><br>';
				} elseif ($value == ".") {
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_format" value=",">Comma (example: $12,54)</label><br>';
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_format" value="." checked>Dot (example: $12.54)</label><br>';
				} else {
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_format" value="," checked>Comma (example: $12,54)</label><br>';
					echo '<label><input class="acwp-settings-radio" type="radio" name="acwp_format" value=".">Dot (example: $12.54)</label><br>';
				}

				echo '<p class="acwp-explanation">Choose whether you would like your customers to see . or , when separating whole amount against the cents amount.</p>';
		}

		public function successPage()
    {
        $value = esc_attr( get_option( 'success_page' ) );
				$strlen = strlen($value) + 5;
				if ($strlen < 20) {
					$strlen = 20;
				}
        echo '<input type="text" class="acwp-settings-text" name="success_page" value="' . $value . '" placeholder=" " size="'. $strlen . '"><br>';
				echo '<p class="acwp-explanation">This is the page to which your customers are redirected when they have successfuly paid. This can be overwritten in each payment form settings.</p>';

		}

		public function failurePage()
    {
        $value = esc_attr( get_option( 'failure_page' ) );
				$strlen = strlen($value) + 5;
				if ($strlen < 20) {
					$strlen = 20;
				}
        echo '<input type="text" class="acwp-settings-text" name="failure_page" value="' . $value . '" placeholder=" " size="'. $strlen . '"><br>';
				echo '<p class="acwp-explanation">This is the page to which your customers are redirected when the payment is not succesful. This can be overwritten in each payment form settings.</p>';
    }

}
