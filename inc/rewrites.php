<?php
namespace PWCC\PatternLabWP\Rewrites;

function init_rewrites() {
	if ( ! class_exists( 'HM_Rewrite' ) ) {
		// Pattern Lab wewrites require hm-rewrites
		// https://github.com/humanmade/hm-rewrite
		return;
	}
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\init_rewrites' );
