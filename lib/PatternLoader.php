<?php

class Mustache_Loader_PatternLoader extends Mustache_Loader_FilesystemLoader {
	
	public function __construct() {
	}
	
	
    protected function getFileName($name)
    {
        $fileName = \PatternLabWP\LocatePatterns\locate_pattern( $name );
        return $fileName;
    }
	
}
