<?php
namespace ApplicationInsights\WordPress;

/**
 * Does client-side instrumentation using the Javascript SDK for Application Insights
 */
class Client_Instrumentation
{
   function addPrefix() {
        $rawSnippet = '<script type="text/javascript">
          var appInsights=window.appInsights||function(a){
                function b(a){c[a]=function(){var b=arguments;c.queue.push(function(){c[a].apply(c,b)})}}var c={config:a},d=document,e=window;setTimeout(function(){var b=d.createElement("script");b.src=a.url||"https://az416426.vo.msecnd.net/scripts/a/ai.0.js",d.getElementsByTagName("script")[0].parentNode.appendChild(b)});try{c.cookie=d.cookie}catch(a){}c.queue=[];for(var f=["Event","Exception","Metric","PageView","Trace","Dependency"];f.length;)b("track"+f.pop());if(b("setAuthenticatedUserContext"),b("clearAuthenticatedUserContext"),b("startTrackEvent"),b("stopTrackEvent"),b("startTrackPage"),b("stopTrackPage"),b("flush"),!a.disableExceptionTracking){f="onerror",b("_"+f);var g=e[f];e[f]=function(a,b,d,e,h){var i=g&&g(a,b,d,e,h);return!0!==i&&c["_"+f](a,b,d,e,h),i}}return c    
            }({
                instrumentationKey:"INSTRUMENTATION_KEY"
            });
            
            window.appInsights=appInsights,appInsights.queue&&0===appInsights.queue.length&&appInsights.trackPageView(PAGE_NAME, PAGE_URL);
        </script>';
        
        $patterns = array();
        $replacements = array();

        /* Instrumentation Key */
        $patterns[0] = '/INSTRUMENTATION_KEY/';
        
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

        $replacements[0] = $application_insights_options["instrumentation_key"];

        $patterns[1] = '/PAGE_NAME/';
        $replacements[1]  = json_encode(Common::getPageTitle());

        $patterns[2] = '/PAGE_URL/';
        if (is_home() == false)
        {
            $replacements[2] = 'window.location.origin';
        }
        else
        {
            $replacements[2] = 'window.location.origin + "/'.rawurlencode(get_the_title()).'"';
        }

        echo preg_replace($patterns, $replacements, $rawSnippet);
    }
}
