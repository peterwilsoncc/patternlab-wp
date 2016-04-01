<?php
namespace PatternLabWP\LocatePatterns;

/**
 * Generates a dictionary of patterns against their file names
 *
 * The dictionary is based of the Pattern Lab method of term-pattern.
 *
 * @TODO caching.
 */
function pattern_dictionary() {
	// Editions are in least to most imporant.
	$editions = array(
		PATTERNLABWP_DEFAULTS,
		TEMPLATEPATH   . '/_patterns',
		STYLESHEETPATH . '/_patterns',
	);
	
	static $dictionary = array();
	if ( ! empty( $dictionary ) ) {
		// Dictionary already generated on this run.
		return $dictionary;
	}
	
	foreach ( $editions as $edition ) {
		if ( ! is_dir( $edition ) ) {
			continue;
		}
		$terms = scandir( $edition );
		$terms = term_dictionary( $edition, $terms );
		$dictionary = array_merge( $dictionary, $terms );
	}
	
	return $dictionary;
}

function term_dictionary( $path, $terms ) {
	// Remove parent and self reference
	$terms = array_diff( $terms, array( '.', '..' ) );
	
	$dictionary = array();

	foreach ( $terms as $term ) {
		if ( ! is_dir( $path . "/$term" ) ) {
			continue;
		}
		$term_path = $path . "/$term";
		preg_match( '/(_?)(\d+-)?([\w-]+?)s?\b/', $term, $matches );
		$term = $matches[3];
		// $dictionary[ $term ] = $term_path;
		$dictionary = array_merge( $dictionary, term_patterns( $term, $term_path ) );
	}
	
	return $dictionary;
}

function term_patterns( $term, $term_path ) {
	$dictionary = array();
	
	$patterns = scandir( $term_path );
	$patterns = array_diff( $patterns, array( '.', '..' ) );
	
	$sub_term = basename( $term_path );
	preg_match( '/(_?)(\d+-)?([\w-]+?)s?\b/', $sub_term, $matches );
	$sub_term = $matches[3];
	
	
	foreach ( $patterns as $pattern ) {
		$pattern_path = $term_path . "/$pattern";
		if ( is_dir( $pattern_path ) ) {
			$dictionary = array_merge( $dictionary, term_patterns( $term, $pattern_path ) );
			continue;
		}
		// It's a file
		preg_match( '/(_?)(\d+-)?([\w-]+?)s?(.php|.mustache)?\b/', $pattern, $matches );
		$pattern = $matches[3];
		$dictionary[ $term . '-' . $pattern ] = array( 
			'file'     => $pattern_path,
			'sub_term' => $sub_term,
		);
	}
	
	return $dictionary;
}

function locate_pattern($pattern_names, $load = false, $require_once = true ) {
	$located = '';
	foreach ( (array) $pattern_names as $pattern_name ) {
		if ( ! $pattern_name ) {
			continue;
		}
		$file = pattern_dictionary()[ $pattern_name ]['file'];
		if ( file_exists( $file ) ) {
			$located = $file;
			break;
		}
	}

	if ( $load && '' != $located ) {
		load_template( $located, $require_once );
	}

	return $located;
}
