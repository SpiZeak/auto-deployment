<?php
/**
 * Plugin Name: Automatic deployment
 * Plugin URI: https://github.com/SpiZeak/auto-deployment
 * Description: A Wordpress plugin that sets up a deployment endpoint which runs a deployment script
 * Version: 1.0
 * Author: Max Trewhitt
 * Author URI: https://max.trewhitt.se
 */
function auto_deployment( $data ) {
	$plugin_url = plugin_dir_url(__FILE__);
	$output = shell_exec("bash $plugin_url/deploy.sh");

	/**
	 * Check if deployment script returns an error
	 */
	if( $output ) echo $output;
	else echo 'Deployment failed.';

	die();
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'webhook', '/deploy', array(
		'methods' => 'POST',
		'callback' => 'auto_deployment',
	) );
} );
