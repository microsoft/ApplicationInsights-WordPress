<?php
/*
Plugin Name: Application Insights
Description: Integrates a WordPress site with Microsoft Application Insights.
Version: 2.3
Author: ApplicationInsights
License:  MIT
 */

require_once 'vendor/autoload.php';

// Enables Admin configuration experience
$mySettingsPage = new ApplicationInsights\WordPress\Settings();

// Enables client-side instrumentation
$clientInstrumentation = new ApplicationInsights\WordPress\Client_Instrumentation();
add_action('wp_head', array($clientInstrumentation, 'addPrefix'));

// Enables server-side instrumentation
$serverInstrumentation = new ApplicationInsights\WordPress\Server_Instrumentation();
add_action('shutdown', array($serverInstrumentation, 'endRequest'));
