=== Plugin Name ===
Contributors: ApplicationInsights
Tags: Application Insights
Requires at least: 3.0.1
Tested up to: 4.3
License: MIT
License URI: http://opensource.org/licenses/MIT

Integrates a WordPress site with Microsoft Application Insights.

== Description ==

Integrates a WordPress site with Microsoft Application Insights. More information about Application Insights can be found <a href='http://azure.microsoft.com/en-us/documentation/articles/app-insights-get-started/'>here</a>. 

Active development is done on <a href='https://github.com/Microsoft/AppInsights-WordPress'>GitHub</a>. 

Other SDKs and documentation can be found <a href='https://github.com/Microsoft/AppInsights-Home'>here</a>.

== Installation ==

1. Upload all files to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings -> Application Insights and enter you Instrumentation Key you received from http://portal.azure.com

== Changelog ==
= 2.2 =
* Updating the latest PHP SDK

= 2.1 =
* Removing unnecessary custom event from being logged. 

= 2.0.2 =
* Fixing Client IP Issue by updating to .0.2.4 of the PHP SDK for Application Insights

= 2.0.1 =
* Bug fixes

= 2.0 =
* Expanded to integrate the full Application Insights PHP SDK.

= 1.1 =
* Updated to support latest release of Application Insights which supports automatic error logging.

= 1.0 =
* Initial Version



