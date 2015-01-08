<?php
namespace ApplicationInsights\WordPress;

/**
 * Does client-side instrumentation using the Javascript SDK for Application Insights
 */
class Client_Instrumentation
{
   function addPrefix() {
        $rawSnippet = '<script type="text/javascript">
            var appInsights=window.appInsights||function(config){
                function s(config){t[config]=function(){var i=arguments;t.queue.push(function(){t[config].apply(t,i)})}}var t={config:config},r=document,f=window,e="script",o=r.createElement(e),i,u;for(o.src=config.url||"//az416426.vo.msecnd.net/scripts/a/ai.0.js",r.getElementsByTagName(e)[0].parentNode.appendChild(o),t.cookie=r.cookie,t.queue=[],i=["Event","Exception","Metric","PageView","Trace"];i.length;)s("track"+i.pop());return config.disableExceptionTracking||(i="onerror",s("_"+i),u=f[i],f[i]=function(config,r,f,e,o){var s=u&&u(config,r,f,e,o);return s!==!0&&t["_"+i](config,r,f,e,o),s}),t
            }({
                instrumentationKey:"INSTRUMENTATION_KEY"
            });
    
            window.appInsights=appInsights;
            appInsights.trackPageView("PAGE_NAME", PAGE_URL);
        </script>';
       
        $patterns = array();
        $replacements = array();
       
        /* Instrumentation Key */
        $patterns[0] = '/INSTRUMENTATION_KEY/';
        $application_insights_options = get_option("applicationinsights_options");
        $replacements[0] = $application_insights_options["instrumentation_key"];
       
        $patterns[1] = '/PAGE_NAME/';
        if (is_home() == false)
        {
            $replacements[1] = get_the_title();
        }
        else
        {
            $replacements[1] = 'Home';
        }
        
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
