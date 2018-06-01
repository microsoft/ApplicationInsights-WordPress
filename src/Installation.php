<?php
namespace ApplicationInsights\WordPress;

/**
 *  Does server-side instrumentation using the PHP SDK for Application Insights
 */
class Installation {
    public static function activation() {
        
        $defaults = [
            'track_404_exceptions' => implode("\n", 
                Common::getDefaultUntrackable404Files())
        ];
    
        $old = get_option('applicationinsights_options');
        if ($old === false) {
            update_option('applicationinsights_options', $defaults);
        }
        else {
            $current = array_merge($defaults, $old);
        
            update_option('applicationinsights_options', $current);
        }
        
    } 
}