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
		
		foreach($this->annotations as $annotation)
		{
			if(!$annotation instanceof ControllerActionAnnotation)
			{
				throw new InvalidArgumentException("Annotation $annotation on %s is not a ControllerActionAnnotation", $this->controller->name);
			}
		}
	}
	
	public function invokeEach($annotation)
	{
		$annotation->invoke($this->controller);
	}
	
	
}

?>
