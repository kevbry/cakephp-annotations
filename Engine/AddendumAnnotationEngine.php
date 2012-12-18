<?php
App::import('Vendor', 'Annotations.addendum/annotations');
App::uses('AnnotationEngine', 'Engine');

/**
 * Annotation engine using Addendum as a back-end.
 * Annotation class is provided by addendum include
 *
 * @author kevbry
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
		$reflection_method = new ReflectionAnnotatedMethod($this->class, $method);
		return $reflection_method->getAllAnnotations();
	}
	
	public function annotationsForProperty($property_name)
	{
		return null;
	}
}

/**
 * Addendum Annotation class provides the required behaviour
 */
class CakeAnnotation extends Annotation
{
	public $value;
}

?>
