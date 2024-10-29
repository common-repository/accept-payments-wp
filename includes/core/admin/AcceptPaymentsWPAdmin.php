<?php

/**
 * @package  Accept Payments WP
 */

namespace AcceptPaymentsWPInc\Core\Admin;

use AcceptPaymentsWPInc\Core\AcceptPaymentsWPBaseController;


class AcceptPaymentsWPAdmin extends AcceptPaymentsWPBaseController
{
	public $settings;
	public $callbacks;

	public $sub_pages = array();

	public function register()
	{
		$this->settings = new AcceptPaymentsWPSettingsApi();

		$this->callbacks = new Callbacks\AcceptPaymentsWPAdminCallbacks();

		$this->setSubpages();

		// set settings, sections and options
    $this->setSettings();
    $this->setSections();
    $this->setFields();

		$this->settings->addSubPages( $this->sub_pages )->register();
	}

	public function setSubpages()
	{
		$this->sub_pages = array(
	    array(
	        'parent_slug' => 'edit.php?post_type=' . $this->plugin_name,
	        'page_title' => 'Settings',
	        'menu_title' => 'Settings',
	        'capability' => 'manage_options',
	        'menu_slug' => $this->plugin_name . '_settings',
	        'callback' => array( $this->callbacks, 'adminSettings' )
	    ),
			array(
	        'parent_slug' => 'edit.php?post_type=' . $this->plugin_name,
	        'page_title' => '24/7 Support And Feature Request',
	        'menu_title' => '24/7 Support And Feature Request',
	        'capability' => 'read',
	        'menu_slug' => $this->plugin_name . '_support',
	        'callback' => array( $this->callbacks, 'adminSupport' )
	    ),
		);
	}

    public function setSettings()
    {
        $args = array(
						array(
								'option_group' => 'braintree_test_mode_options_group',
								'option_name' => 'test_mode',
								'callback' => array( $this->callbacks, 'checkboxValidator' )
						),
						array(
                'option_group' => 'braintree_connection_options_group',
                'option_name' => 'merchant_id',
                'callback' => array( $this->callbacks, 'textValidator' )
            ),
						array(
                'option_group' => 'braintree_connection_options_group',
                'option_name' => 'public_key',
                'callback' => array( $this->callbacks, 'textValidator' )
            ),
						array(
                'option_group' => 'braintree_connection_options_group',
                'option_name' => 'private_key',
                'callback' => array( $this->callbacks, 'textValidator' )
            ),
						array(
                'option_group' => 'braintree_connection_options_group',
                'option_name' => 'tokenization_key',
                'callback' => array( $this->callbacks, 'textValidator' )
            ),
						array(
                'option_group' => 'payment_form_options_group',
                'option_name' => 'acwp_currency',
                'callback' => array( $this->callbacks, 'currencyValidator' ) #TODO fix callback
            ),

						array(
                'option_group' => 'payment_form_options_group',
                'option_name' => 'acwp_format',
                'callback' => array( $this->callbacks, 'formatValidator' ) #TODO fix callback
            ),

						array(
                'option_group' => 'payment_form_options_group',
                'option_name' => 'success_page',
                'callback' => array( $this->callbacks, 'urlValidator' ) #TODO fix callback
            ),
						array(
                'option_group' => 'payment_form_options_group',
                'option_name' => 'failure_page',
                'callback' => array( $this->callbacks, 'urlValidator' )
            ),
        );

        $this->settings->setSettings( $args );
    }

    public function setSections()
    {
        $args = array(
						array(
								'id' => $this->plugin_name. '_braintree_test_mode_index',
								'title' => '',
								'callback' => array( $this->callbacks, 'settingsSection' ),
								'page' => $this->plugin_name . '_settings'
						),
            array(
                'id' => $this->plugin_name. '_braintree_connection_index',
                'title' => '',
                'callback' => array( $this->callbacks, 'settingsSection' ),
                'page' => $this->plugin_name . '_settings'
            ),
						array(
                'id' => $this->plugin_name. '_payment_form_behaviour_index',
                'title' => '',
                'callback' => array( $this->callbacks, 'settingsSection' ),
                'page' => $this->plugin_name . '_settings'
            )
        );

        $this->settings->setSections( $args );
    }

    public function setFields()
    {
        $args = array(
						array(
								'id' => 'test_mode', // needs to be identical to option_group parameter of setSettings()
								'title' => 'Enable Test Mode',
								'callback' => array( $this->callbacks, 'testMode' ),
								'page' => $this->plugin_name . '_settings', // needs to be identical to menu_slug parameter of setPages() or setSubPages()
								'section' => $this->plugin_name. '_braintree_test_mode_index', // needs to be identical to id of setSections()
								'args' => array(
										'label_for' => 'test_mode',
										'class' => 'settings-checkbox'
								)
						),
						array(
                'id' => 'merchant_id', // needs to be identical to option_group parameter of setSettings()
                'title' => 'Merchant ID',
                'callback' => array( $this->callbacks, 'merchantID' ),
                'page' => $this->plugin_name . '_settings', // needs to be identical to menu_slug parameter of setPages() or setSubPages()
                'section' => $this->plugin_name. '_braintree_connection_index', // needs to be identical to id of setSections()
                'args' => array(
                    'label_for' => 'merchant_id',
                    'class' => 'settings-text-field'
                )
            ),
						array(
                'id' => 'public_key', // needs to be identical to option_group parameter of setSettings()
                'title' => 'Public Key',
                'callback' => array( $this->callbacks, 'publicKey' ),
                'page' => $this->plugin_name . '_settings', // needs to be identical to menu_slug parameter of setPages() or setSubPages()
                'section' => $this->plugin_name. '_braintree_connection_index', // needs to be identical to id of setSections()
                'args' => array(
                    'label_for' => 'public_key',
                    'class' => 'settings-text-field'
                )
            ),
						array(
                'id' => 'private_key', // needs to be identical to option_group parameter of setSettings()
                'title' => 'Private Key',
                'callback' => array( $this->callbacks, 'privateKey' ),
                'page' => $this->plugin_name . '_settings', // needs to be identical to menu_slug parameter of setPages() or setSubPages()
                'section' => $this->plugin_name. '_braintree_connection_index', // needs to be identical to id of setSections()
                'args' => array(
                    'label_for' => 'private_key',
                    'class' => 'settings-text-field'
                )
            ),
						array(
                'id' => 'tokenization_key', // needs to be identical to option_group parameter of setSettings()
                'title' => 'Tokenization Key:',
                'callback' => array( $this->callbacks, 'tokenizationKey' ),
                'page' => $this->plugin_name . '_settings', // needs to be identical to menu_slug parameter of setPages() or setSubPages()
                'section' => $this->plugin_name. '_braintree_connection_index', // needs to be identical to id of setSections()
                'args' => array(
                    'label_for' => 'tokenization_key',
                    'class' => 'settings-text-field'
                )
            ),
						array(
                'id' => 'acwp_currency', // needs to be identical to option_group parameter of setSettings()
                'title' => 'Currency',
                'callback' => array( $this->callbacks, 'acwpCurrency' ),
                'page' => $this->plugin_name . '_settings', // needs to be identical to menu_slug parameter of setPages() or setSubPages()
                'section' => $this->plugin_name. '_payment_form_behaviour_index', // needs to be identical to id of setSections()
                'args' => array(
                    'label_for' => 'acwp_currency',
                    'class' => 'settings-dropdown'
                )
            ),
						array(
                'id' => 'acwp_format', // needs to be identical to option_group parameter of setSettings()
                'title' => 'Format',
                'callback' => array( $this->callbacks, 'acwpFormat' ),
                'page' => $this->plugin_name . '_settings', // needs to be identical to menu_slug parameter of setPages() or setSubPages()
                'section' => $this->plugin_name. '_payment_form_behaviour_index', // needs to be identical to id of setSections()
                'args' => array(
                    'label_for' => 'acwp_format',
                    'class' => 'settings-dropdown'
                )
            ),
						array(
                'id' => 'success_page_url', // needs to be identical to option_group parameter of setSettings()
                'title' => 'Success Page URL',
                'callback' => array( $this->callbacks, 'successPage' ),
                'page' => $this->plugin_name . '_settings', // needs to be identical to menu_slug parameter of setPages() or setSubPages()
                'section' => $this->plugin_name. '_payment_form_behaviour_index', // needs to be identical to id of setSections()
                'args' => array(
                    'label_for' => 'success_page_url',
                    'class' => 'settings-text-field'
                )
            ),
						array(
                'id' => 'failure_page_url', // needs to be identical to option_group parameter of setSettings()
                'title' => 'Failure Page URL',
                'callback' => array( $this->callbacks, 'failurePage' ),
                'page' => $this->plugin_name . '_settings', // needs to be identical to menu_slug parameter of setPages() or setSubPages()
                'section' => $this->plugin_name. '_payment_form_behaviour_index', // needs to be identical to id of setSections()
                'args' => array(
                    'label_for' => 'failure_page_url',
                    'class' => 'settings-text-field'
                )
            )
        );

        $this->settings->setFields( $args );
    }

}
