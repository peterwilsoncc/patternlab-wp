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
	
	foreach ( $patterns as $pattern ) {
		$pattern_path = $term_path . "/$pattern";
		if ( is_dir( $pattern_path ) ) {
			$dictionary = array_merge( $dictionary, term_patterns( $term, $pattern_path ) );
			continue;
		}
		// It's a file
		preg_match( '/(_?)(\d+-)?([\w-]+?)(.php|.mustache)?\b/', $pattern, $matches );
		$pattern = $matches[3];
		$dictionary[ $term . '-' . $pattern ] = $pattern_path;
	}
	
	return $dictionary;
}

