<?php

/**
 * @package  Accept Payments WP
 */

namespace AcceptPaymentsWPInc\Core;

use AcceptPaymentsWPInc\Core\AcceptPaymentsWPBaseController;
use Braintree\Gateway;

class PaymentFormsController extends AcceptPaymentsWPBaseController
{
  public $braintree_api;

  public function register()
  {
    // Hooks

    # Register post type
    add_action( 'init', array( $this, 'accept_payments_wp_activate'));

    # Meta Boxes
    add_action( 'add_meta_boxes', array( $this, 'accept_payments_wp_meta_boxes'));
    add_action( 'save_post', array( $this, 'accept_payments_wp_save_meta_box_data'));

    # View all display settings
    add_action( 'manage_'.$this->plugin_name.'_posts_columns', array( $this, 'set_acwp_custom_columns' ) );
    add_action( 'manage_'.$this->plugin_name.'_posts_custom_column', array( $this, 'set_acwp_custom_columns_data' ), 10, 2 );

    # Shortocodes
    add_shortcode( 'accept-payments', array ( $this, 'accept_payments_wp_display_payment_form') );

    # ajax call handling
    add_action('wp_ajax_accept_payments_wp_proccess_nonce', array($this, 'accept_payments_wp_proccess_nonce')); // If the user is logged in
    add_action('wp_ajax_nopriv_accept_payments_wp_proccess_nonce', array($this, 'accept_payments_wp_proccess_nonce')); // If the user in not logged in
  }

  // ---- Register Post Types ---- //
  public function accept_payments_wp_activate()
  {
    register_post_type( $this->plugin_name,
    array(
      'labels' => array(
        'name' => 'Payment Forms',
        'singular_name' => 'Payment Form',
        'all_items' => 'Payment Forms',
        'menu_name' => 'Accept Payments',
        'add_new' => 'Add New Payment Form',
        'add_new_item' => 'Add New Payment Form',
        'edit_item' => 'Edit Payment Form',
      ),
      'supports' => array('title', 'custom_fields'),
      'public' => true,
      'has_archive' => true,
      'exclude_from_search' => true,
      'publicly_queryable' => false,
      'menu_icon' => 'dashicons-accept-payments-wp'
    )
  );

  }

  // ---- Payment Form MetaBox Functions --- //
  public function accept_payments_wp_meta_boxes()
  {
    add_meta_box( 'payment_form_settings',
                  'Payment Form Settings',
                  array( $this, 'accept_payments_wp_render_payment_form_settings_meta_box'),
                  $this->plugin_name,
                  $context = 'normal',
                  $priority = 'default',
                  $callback_args = null
                );
  }

  public function accept_payments_wp_render_payment_form_settings_meta_box($post)
  {
    wp_nonce_field( 'payment_form_settings_meta_box',
                    'payment_form_settings_meta_box_nonce'
                  );

    $value = get_post_meta( $post -> ID, '_payment_form_settings_meta_box_key', true);

    $meta_boxes_controller = new AcceptPaymentsWPMetaBoxes();
    $meta_boxes_controller->buildPaymentFormSettingsMetaBox($value, $post -> ID);

  }

  public function accept_payments_wp_save_meta_box_data($post_id)
  {
    if (! isset($_POST['payment_form_settings_meta_box_nonce']) ) {
      return $post_id;
    }

    $nonce = $_POST['payment_form_settings_meta_box_nonce'];

    if (! wp_verify_nonce( $nonce, 'payment_form_settings_meta_box' )) {
      return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }

    if (! current_user_can( 'edit_post', $post_id )) {
      return $post_id;

    }

    $data = array(
      'price' => sanitize_text_field( $_POST['price_field'] ),
      'item_description' => sanitize_text_field( $_POST['item_description'] ),
      'success_page_url' => sanitize_text_field( $_POST['success_page_url'] ),
      'failure_page_url' => sanitize_text_field( $_POST['failure_page_url'] ),
      'button_text' => sanitize_text_field( $_POST['button_text'] ),

    );

    update_post_meta ( $post_id, '_payment_form_settings_meta_box_key', $data);

  }

  // ---- View all display settings ---- //
  public function set_acwp_custom_columns($columns)
  {
    $date_col = $columns['date'];
    unset($columns['date']);
    $columns['item_description'] = "Description";
    $columns['shortcode'] = "Shortcode";
    $columns['date'] = $date_col;
    return $columns;
  }

  public function set_acwp_custom_columns_data($column, $post_id)
  {
    $post_meta = get_post_meta( $post_id, '_payment_form_settings_meta_box_key', true);

    switch($column){
      case 'item_description':
        echo '<p>' . $post_meta['item_description'] . '</p><br>';
        break;
      case 'shortcode':
        echo '<input size="25" type="text" value="[accept-payments id='.$post_id.']" readonly/><br>';
        break;
    }

  }

  // ---- Payment Form Display On The Front End ---- //
  public function accept_payments_wp_display_payment_form($atts)
  {
    if ( get_option( 'test_mode' ) != "1" ) {
      $test_mode = false;
    } else {
      $test_mode = true;
    }

    if ( $test_mode == false & !get_option( 'merchant_id' )  | !get_option( 'public_key' )
          | !get_option( 'private_key' ) | !get_option( 'tokenization_key' )
          | !get_option( 'acwp_currency' ) ) {

      ob_start();
      echo '<p style="color:red">Not all form settings are set. Please go to the Accept Payments WP settings page and fill in all the fields, or enable the test mode if you are just trying the plugin out.</p>';
      return ob_get_clean();
    }
    extract(shortcode_atts( array(
      'id' => null
    ), $atts));

    if (isset($atts['id'])) {
      $form_params = get_post_meta( $atts['id'], '_payment_form_settings_meta_box_key', true);
    } else {
      return;
    }

    ob_start();
    wp_enqueue_style( 'accept_payments_wp_form_styles', $this->plugin_url . "assets/css/accept_payments_wp_payment-form.css" );
    wp_enqueue_script( 'accept_payments_wp_braintree_form_script', 'https://js.braintreegateway.com/web/dropin/1.14.1/js/dropin.min.js' );

    $form_builder = new Payments\AcceptPaymentsWPFormBuilder($form_params, $test_mode);
    $form_builder -> build_form();


    wp_register_script( 'payment_form_script', $this->plugin_url . 'assets/js/accept_payments_wp_payment-form.js' );

    $script_args = array(
      'successPage' => esc_attr( $form_params['success_page_url'] ),
      'failurePage' => esc_attr( $form_params['failure_page_url'] )
    );

    if ($test_mode == false) {
      $script_args['tokenizationKey'] = esc_attr( get_option( 'tokenization_key' ) );
    } else {
      $script_args['tokenizationKey'] = 'sandbox_9mnrnth2_677zwb6jwpr6mr2h'; # TODO encode this when activating the plugin
    }

    wp_localize_script( 'payment_form_script', 'scriptParams', $script_args );
    wp_enqueue_script( 'payment_form_script' );

    return ob_get_clean();
  }

  // ---- Payment Handling Logic --- //
  public function accept_payments_wp_proccess_nonce()
  {
    $nonce_from_the_client = $_POST['payment_method_nonce'];
    $price = $_POST['price'];

    // Add Payment Processing logic here.
    $this -> braintree_api = new Payments\BraintreeAPI();
    $braintree_gateway = $this -> braintree_api -> gateway;

    $result = $braintree_gateway->transaction()->sale([
                          'amount' => $price,
                          'paymentMethodNonce' => $nonce_from_the_client,
                          'options' => [
                            'submitForSettlement' => True
                          ]
                        ]);

    $return = array(
      'success' => $result->success
    );


    wp_send_json($return);

    wp_die();

  }

}
