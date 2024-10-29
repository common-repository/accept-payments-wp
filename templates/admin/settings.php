<div class="wrap">
    <h1>Settings</h1>
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab-1">Test Mode</a></li>
      <li><a href="#tab-2">Connect To Braintree</a></li>
      <li><a href="#tab-3">Payment Form Behaviour</a></li>
    </ul>

    <div class="tab-content">
      <div id="tab-1" class="tab-pane active">
        <p class="acwp-explanation">If you enable test mode you DO NOT need to set any other settings. You can create & test payment forms immediately to check if this plugin is for you. To learn more about test mode and how it works, we wrote a short blog post: <a href="https://medium.com/@AcceptPaymentsWP/accept-payments-wp-test-mode-explained-223b4cfaf972" target="_blank">Click Here To Read It.</a></p>
        <form method="post" action="options.php">
          <table class="form-table">
            <?php
            settings_fields( 'braintree_test_mode_options_group' ); // name of options_group in Admin.php->setSettings()
            do_settings_fields( $this->plugin_name . '_settings', $this->plugin_name. '_braintree_test_mode_index');      // name of page in Admin.php->setSections()
            ?>
          </table>
          <?php
          submit_button();
          ?>
        </form>
      </div>
      <div id="tab-2" class="tab-pane">
        <p class="acwp-explanation">When someone pays on your website, you want that money to reach you and not someone else.
          For that reason, you need to enter some keys which will route the money to your account. You can find all of them in your
          Braintree Control Panel. If you need help to locate those, we have a step by step guide (3 minute effort): <a target="_blank" href="https://medium.com/@AcceptPaymentsWP/how-to-connect-braintree-payments-account-to-your-wordpress-website-97a4b79bde53">Click Here For The Tutorial.</a></p>
        <form method="post" action="options.php">
          <table class="form-table">
            <?php
            settings_fields( 'braintree_connection_options_group' ); // name of options_group in Admin.php->setSettings()
            do_settings_fields( $this->plugin_name . '_settings', $this->plugin_name. '_braintree_connection_index');      // name of page in Admin.php->setSections()
            ?>
          </table>
          <?php
          submit_button();
          ?>
        </form>
      </div>

      <div id="tab-3" class="tab-pane">
        <form method="post" action="options.php">
          <table class="form-table">
            <?php
            settings_fields( 'payment_form_options_group' ); // name of options_group in Admin.php->setSettings()
            do_settings_fields( $this->plugin_name . '_settings', $this->plugin_name. '_payment_form_behaviour_index');      // name of page in Admin.php->setSections()
            ?>
          </table>
          <?php
          submit_button();
          ?>
        </form>
      </div>

    </div>


</div>
