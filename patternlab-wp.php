<?php
namespace PatternLabWP;

// Include Mustache if it does not exist.
if ( ! class_exists( 'Mustache_Engine' ) ) {
	// This copy of Mustache was taken from the WordPress VIP svn server
	// to include any hard coded modifications WPVIP may have made to
	// improve the security of the library.
	// Source: https://vip-svn.wordpress.com/plugins/lib/Mustache/
	include 'lib/Mustache/0-load.php';
}
