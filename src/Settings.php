<?php
namespace ApplicationInsights\WordPress;

/**
 * Sets up Admin settings
 **/
class Settings {
    private $options;
    
    public function __construct()
    {
         /* Necessary check for mult-isite installation */
        if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
            require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        }   
        if ( is_multisite() && is_plugin_active_for_network( 'application-insights/ApplicationInsightsPlugin.php' ) ) {
            add_action('network_admin_menu', array($this, 'addAdminMenuNetwork'));
        }
        else {
            add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
        }
        add_action('network_admin_edit_applicationinsights-setting-admin',  array( $this, 'applicationinsights_options'));
        add_action( 'admin_init', array( $this, 'pageInitialization' ) );
    }
    
    public function addAdminMenu()
    {
        // This page will be under "Settings"
        add_options_page(
            'Application Insights Plugin Options', 
            'Application Insights', 
            'manage_options', 
            'applicationinsights-setting-admin', 
            array( $this, 'createAdminPage' )
        );
    }
    
    public function addAdminMenuNetwork()
    {
        if ( ! function_exists( 'is_plugin_active_for_network' ) && is_multisite() ) {
            // need to include the plugin library for the is_plugin_active function
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        if ( is_multisite() && is_plugin_active_for_network( 'application-insights/ApplicationInsightsPlugin.php' ) ) {
            // add options page to the settings menu
            add_submenu_page(
                'settings.php',				//slug of parent
                'Application Insights Plugin Options',			//Title
                'Application Insights',			//Sub-menu title
                'manage_network_options',       // Capabilities
                'applicationinsights-setting-admin',	//Menu Slug
                array( $this, 'createNetworkAdminPage' )		//Function to call
            );
        } 
    }
    
    public function createAdminPage()
    {     
       // Set class property
        $this->options = get_option( 'applicationinsights_options' );
        ?>
            <div class="wrap">
                <?php echo _e('Application Insights Settings', 'applicationinsights'); ?>           
                <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'applicationinsights_option_group' );   
                do_settings_sections( 'applicationinsights-setting-admin' );
                submit_button(); 
            ?>
                </form>
            </div>
        <?php
    }
    
    public function createNetworkAdminPage()
    {     
        if (isset($_GET['updated'])): ?>
            <div id="message" class="updated notice is-dismissible"><p><?php _e('Options saved.') ?></p></div>
        <?php endif; 
            // Set class property
            $this->options = get_site_option( 'applicationinsights_options' );
        ?>
            <div class="wrap">
                <h2><?php echo _e('Application Insights Settings', 'applicationinsights'); ?></h2>
                <form method="POST" action="edit.php?action=applicationinsights-setting-admin">
            <?php
                // This prints out all hidden setting fields
                settings_fields('applicationinsights_option_group');
                do_settings_sections('applicationinsights-setting-admin');
                submit_button(); 
            ?>
                </form>
            </div>
        <?php
    }
    
    public function pageInitialization()
    {        
        register_setting('applicationinsights_option_group', 'applicationinsights_options');
        add_settings_section('main_section', 'Application Settings', null, 'applicationinsights-setting-admin');  
        add_settings_field('instrumentation_key', 'Instrumentation Key', array( $this, 'instrumentationKeyCallback' ), 'applicationinsights-setting-admin', 'main_section');      
    }

    public function instrumentationKeyCallback()
    {
        printf(
            '<input style="width: 450px" type="text" id="instrumentation_key" name="applicationinsights_options[instrumentation_key]" value="%s" />',
            isset( $this->options['instrumentation_key'] ) ? esc_attr( $this->options['instrumentation_key'] ) : ''
        );
    }
    
    
    
    /**
    * This function here is hooked up to a special action and necessary to process
    * the saving of the options. This is the big difference with a normal options
    * page.
    */
    
    function applicationinsights_options() 
    {
        // Make sure we are posting from our options page. There's a little surprise
        // here, on the options page we used the 'applicationinsights_option_group'
        // slug when calling 'settings_fields' but we must add the '-options' postfix
        // when we check the referer.
        check_admin_referer('applicationinsights_option_group-options');
        
        // This is the list of registered options.
        global $new_whitelist_options;
        // pick option group
        $options = $new_whitelist_options['applicationinsights_option_group'];

        // Go through the posted data and save only our options. This is a generic
        // way to do this, but you may want to address the saving of each option
        // individually.
        foreach ($options as $option) {           
            if (isset($_POST[$option])) {
                // If we registered a callback function to sanitizes the option's
                // value it is where we call it (see register_setting).
                $option_value = apply_filters('sanitize_option_' . 'applicationinsights_option_group', $_POST[$option]);
                // And finally we save our option with the site's options.
                update_site_option($option, $option_value);
            } else {
                // If the option is not here then delete it. It depends on how you
                // want to manage your defaults however.
                delete_site_option($option);
            }
        }
        
        // At last we redirect back to our options page.
        wp_redirect(add_query_arg(array('page' => 'applicationinsights-setting-admin',
            'updated' => 'true'), network_admin_url('settings.php')));
        exit;
    }
}