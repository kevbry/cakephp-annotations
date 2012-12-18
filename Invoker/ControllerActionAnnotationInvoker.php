<?php

App::uses('AnnotationInvoker', 'Invoker');

/**
 * Invoker for executing annotation actions on the current request's controller action
 *
 * @author kevbry
 */
class ControllerActionAnnotationInvoker extends AnnotationInvoker
{
	protected $controller;
	protected $annotations;
	
	public function __construct($controller, $annotations)
	{
		$this->controller = $controller;
		$this->annotations = $annotations;
	}
	
	/**
	 * Handle executing a single annotation
	 * @param ControllerActionAnnotation $annotation The annotation to run
	 */
	protected function invokeAnnotation($annotation)
	{
		$annotation->invoke($this->controller);
	}
}