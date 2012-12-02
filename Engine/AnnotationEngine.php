<?php

/**
 * Description of AbstractAnnotationEngine
 *
 * @author kevinb
 */
interface AnnotationEngine
{
	public function readAnnotationsFromClass($class);
	
	public function annotationsForMethod($method);
	
	public function annotationsForClass();
	
	public function annotationsForProperty($property_name);
}

?>
