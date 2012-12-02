<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
		parent::construct();
		$this->controller = $controller;
		$annotation_engine = $this->loadAnnotationEngine();
		
		$annotation_engine->readAnnotationsFromClass($controller);
		
		$this->annotations = $annotation_engine->annotationsForMethod($controller->request->action);
	}
	
	public function invokeAnnotation(ControllerActionAnnotation $annotation)
	{
		$annotation->invoke($this->controller);
	}
	
	
	
}

?>
