<?php
namespace ApplicationInsights\WordPress;

/**
 * Sets up Admin settings
 **/
class Settings {
    private $options;
    
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
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
    
    public function createAdminPage()
    {
        // Set class property
        $this->options = get_option( 'applicationinsights_options' );
?>
        <div class="wrap">
            <h2>Application Insights Settings</h2>           
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
            isset( $this->options['instrumentation_key'] ) ? esc_attr( $this->options['instrumentation_key']) : ''
        );
    }
}