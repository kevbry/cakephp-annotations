<?php
App::import("Vendor", "Annotations.addendum/annotations");

/**
 * Annotation engine using Addendum as a back-end.
 * Annotation class is provided by addendum include
 *
 * @author kevinb
 */
class AddendumAnnotationEngine implements AnnotationEngine
{
	protected $class;
	public function readAnnotationsFromClass($class)
	{
		$this->class = $class;
	}
	
	public function annotationsForClass()
	{
		return null;
	}
	
	public function annotationsForMethod($method)
	{
		$reflection_method = ReflectionAnnotatedMethod($this->class, $method);
		return $reflection_method->getAllAnnotations();
	}
	
	public function annotationsForProperty($property_name)
	{
		return null;
	}
}

?>
