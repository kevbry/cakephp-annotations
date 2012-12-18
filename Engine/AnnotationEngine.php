<?php

/**
 * Base AnnotationEngine class. Annotation Engine subclasses must provide a 
 *	CakeAnnotation base class with the following properties:
 *		-Single-valued annotations should have their $value property set to the single argument's value
 *		-Multi-valued annotations should have the property with a matching name set to the value of that argument
 *
 * @author kevbry
 */
interface AnnotationEngine
{
	public function readAnnotationsFromClass($class);
	
	public function annotationsForMethod($method);
	
	public function annotationsForClass();
	
	public function annotationsForProperty($property_name);
}
