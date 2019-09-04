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
	$command = 'bash '.dirname(__FILE__).'/deploy.sh 2>&1';

	exec($command, $output);

	foreach ($output as $line) {
		echo "$line\n";
	}

	die();
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'webhook', '/deploy', array(
		'methods' => 'POST',
		'callback' => 'auto_deployment',
	) );
} );
