=== Application Insights ===

Contributors: ApplicationInsights
Tags: Application Insights, monitoring, tracing, telemetry 
Stable Tag: trunk
Requires at least: 3.0.1
Requires PHP: 5.2.4
Tested up to: 4.9.6
License: MIT
License URI: http://opensource.org/licenses/MIT

Integrates a WordPress site with Microsoft Application Insights.

== Description ==

Integrates a WordPress site with Microsoft Application Insights. More information about Application Insights can be found [here](http://azure.microsoft.com/en-us/documentation/articles/app-insights-get-started/). 

Active development is done on [GitHub](https://github.com/Microsoft/AppInsights-WordPress). 

Other SDKs and documentation can be found [here](https://github.com/Microsoft/AppInsights-Home).

== Installation ==

1. Upload all files to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings -> Application Insights and enter the Instrumentation Key you received from http://portal.azure.com. Use direct link https://ms.portal.azure.com/#create/Microsoft.AppInsights to create a new Application Insights resource.

== Changelog ==

= 2.3 =
* Added support for Wordpress Multisite Network.
* Support for `404` pages to be represented as failed requests in portal.

= 2.2 =
* Updated to the latest version of the Application Insights PHP SDK.

= 2.1 =
* Removed unnecessary custom event from being logged. 

= 2.0.2 =
* Fixed Client IP Issue by updating to 0.2.4 of the PHP SDK for Application Insights.

= 2.0.1 =
* Bug fixes.

= 2.0 =
* Expanded to integrate the full Application Insights PHP SDK.

= 1.1 =
* Updated to support latest release of Application Insights which supports automatic error logging.

= 1.0 =
* Initial version.
