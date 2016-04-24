<?php
namespace PatternLabWP;

// Include Mustache if it does not exist.
if ( ! class_exists( 'Mustache_Engine' ) ) {
	// This copy of Mustache was taken from the WordPress VIP svn server
	// to include any hard coded modifications WPVIP may have made to
	// improve the security of the library.
	// Source: https://vip-svn.wordpress.com/plugins/lib/Mustache/
	include __DIR__ . '/lib/Mustache/0-load.php';
}

define( 'PATTERNLABWP_DEFAULTS', __DIR__ . '/_patterns' );
include __DIR__ . '/lib/PatternLoader.php';
include __DIR__ . '/lib/locate-patterns.php';
