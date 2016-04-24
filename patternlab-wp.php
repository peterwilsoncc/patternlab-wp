<?php
namespace PWCC\PatternLabWP;

/**
 * Return either source or build directory for pattern library.
 */
function get_pattern_directory() {
	$source_directory = 'source/';
	$build_directory  = 'build/';

	// Default to build files.
	$use_source_files = false;

	$is_prod  = ( PWCC_PROD   || 'prod'  === PWCC_ENV );
	$is_stage = ( PWCC_STAGE  || 'stage' === PWCC_ENV );
	$is_dev   = ( PWCC_DEV    || 'dev'   === PWCC_ENV );
	
	// Always use source files on dev.
	if ( $is_dev ) {
		$use_source_files = true;
	}

	/**
	 * Add extra check for using the source or build patterns.
	 *
	 * @since 1.0.0
	 *
	 * @param string $use_source_files Source directory of pattern files
	 */
	$use_source_files = apply_filters( 'pwcc_patternlab_use_source', $use_source_files );

	// Detect if the source directory should be used.
	if ( $use_source_files ) {
		/**
		 * Override pattern library source directory.
		 *
		 * @since 1.0.0
		 *
		 * @param string $source_directory Source directory of pattern files
		 */
		$source_directory = apply_filters( 'pwcc_patternlab_source', $source_directory );
		return untrailingslashit( $source_directory ) . '/';
	}

	/**
	 * Override pattern library build directory.
	 *
	 * @since 1.0.0
	 *
	 * @param string $build_directory Source directory of pattern files
	 */
	$build_directory = apply_filters( 'pwcc_patternlab_build', $build_directory );
	return untrailingslashit( $build_directory ) . '/';
}
