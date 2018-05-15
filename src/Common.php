<?php

namespace ApplicationInsights\WordPress;

/**
 * Common code shared thru the application.
 */
class Common
{
    /**
     * Returns the current WordPress Page Title
     * @return string Page Title
     */
    public static function getPageTitle() {
        if (is_home()) {
            // Home Page does not have a name
            return 'Home';
        }
        elseif (is_404()) {
            // WordPress does not know the title for a 404 page
            return 'Page not found';
        }
        else {
            // WordPress Page Title
            return get_the_title();
        }
    }
}