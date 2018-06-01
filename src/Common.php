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

    public static function getDefaultUntrackable404Files() {
        return array(
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
}