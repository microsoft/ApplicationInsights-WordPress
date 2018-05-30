<?php
namespace ApplicationInsights\WordPress;

/**
 *  Does server-side instrumentation using the PHP SDK for Application Insights
 */
class Server_Instrumentation {
	private $_telemetryClient;
	private static $UNTRACKABLE_404;
    private $_isTrack404Enabled;

    public function __construct()
    {
         /* Necessary check for multi-site installation */
        if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
            require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        }   
        if ( is_multisite() && is_plugin_active_for_network("application-insights/ApplicationInsightsPlugin.php") ) 
        {
            $application_insights_options = get_site_option("applicationinsights_options");
        } else {
            $application_insights_options = get_option("applicationinsights_options");
        } 
        $this->_telemetryClient = new \ApplicationInsights\Telemetry_Client();
        $this->_telemetryClient->getContext()->setInstrumentationKey($application_insights_options["instrumentation_key"]);
        $sdkVer = $this->_telemetryClient->getContext()->getInternalContext()->getSdkVersion();
        $this->_telemetryClient->getContext()->getInternalContext()->setSdkVersion('wp_' . $sdkVer);

		set_exception_handler( array( $this, 'exceptionHandler' ) );
	}

    function endRequest()
    {
        if (is_page() || is_single() || is_category() || is_home() || is_archive() || $this->isTrackable404() )
        {
            $url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            $requestName = Common::getPageTitle();
            $startTime = $_SERVER["REQUEST_TIME"];
            $duration = floatval(timer_stop(0, 3)) * 1000;
            $this->_telemetryClient->trackRequest($requestName, $url, $startTime, $duration, http_response_code(), !is_404());

			// Flush all telemetry items
			$this->_telemetryClient->flush();
		}
	}

    function exceptionHandler(\Exception $exception)
    {
        if ($exception != NULL)
        {
            $this->_telemetryClient->trackException($exception);
            $this->_telemetryClient->flush();
        }
    }

	function isTrackable404() {
		$return = false;

		if ( $this->_isTrack404Enabled && is_404() ) {
			$return = ! in_array( $_SERVER['REQUEST_URI'], $this->getUntrackableFiles() );
		}

		return $return;
	}

	function getUntrackableFiles() {
		if ( Server_Instrumentation::$UNTRACKABLE_404 == null ) {
			Server_Instrumentation::$UNTRACKABLE_404 = array(
				'/sitemap.xml',
				'/favicon.ico',
				'/robots.txt',
				'/apple-touch-icon.png',
				'/apple-touch-icon-precomposed.png',
                '/apple-touch-icon-76x76.png',
                '/apple-touch-icon-76x76-precomposed.png',
				'/apple-touch-icon-120x120.png',
				'/apple-touch-icon-120x120-precomposed.png',
                '/apple-touch-icon-152x152.png',
                '/apple-touch-icon-152x152-precomposed.png',
				'/browserconfig.xml',
				'/crossdomain.xml',
				'/labels.rdf',
				'/trafficbasedsspsitemap.xml'
			);
		}

		return Server_Instrumentation::$UNTRACKABLE_404;
	}
}
