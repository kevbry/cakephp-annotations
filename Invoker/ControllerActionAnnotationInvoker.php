<?php

App::uses("AnnotationInvoker", "Annotations.Invoker");

/**
 * Description of ControllerActionAnnotationInvoker
 *
 * @author kevinb
 */
class ControllerActionAnnotationInvoker extends AnnotationInvoker
{
	protected $controller;
	
	public function __construct($controller)
	{
		$this->controller = $controller;
		$annotation_engine = $this->loadAnnotationEngine();
		
		$annotation_engine->readAnnotationsFromClass($controller);
		
		$this->annotations = $annotation_engine->annotationsForMethod($controller->request->action);
	}
	
	//Should be ControllerActionAnnotation... 
	protected function invokeAnnotation($annotation)
	{
		$annotation->invoke($this->controller);
	}
	
	
	
}