<?php
namespace ApplicationInsights\WordPress;

/**
 *  Does server-side instrumentation using the PHP SDK for Application Insights
 */
class Server_Instrumentation
{
    private $_telemetryClient;
    
    public function __construct()
    {
        $application_insights_options = get_option("applicationinsights_options");
        $this->_telemetryClient = new \ApplicationInsights\Telemetry_Client();
        $this->_telemetryClient->getContext()->setInstrumentationKey($application_insights_options["instrumentation_key"]);
        
        set_exception_handler(array($this, 'exceptionHandler'));
    }
    
    function endRequest()
    {
        if (is_page() || is_single() || is_category() || is_home() || is_archive())
        {
            $url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            $requestName = $this->getRequestName();
            $startTime = $_SERVER["REQUEST_TIME"];
            $duration = timer_stop(0, 3) * 1000;
            $this->_telemetryClient->trackRequest($requestName, $url, $startTime, $duration);
            
            // Flush all telemetry items
            $this->_telemetryClient->flush(); 
        }
    }

    function getRequestName()
    {
        if (is_home() == false)
        {
            return get_the_title();
        }
        else
        {
            return 'Home';
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
}
