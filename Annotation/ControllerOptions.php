<?php
App::uses('ControllerActionAnnotation', 'Annotation');

/**
 * Set any controller property
 * @example '@ControllerOptions({autoRender=false,layout='default'})'
 *
 * @author kevbry
 */
class ControllerOptions extends ControllerActionAnnotation
{
	public $value;
	
	/**
	 * 
	 * @param array $value An array of key=>value pairs of controller properties to set and their values
	 */
	public function invoke(Controller $controller)
	{
		foreach($this->value as $name=>$value)
		{
			$controller->{$name} = $value;
		}
	}
	
	public function runForStage($stage)
	{
		if($stage == ComponentCallbacksAnnotationFilter::STAGE_STARTUP)
		{
			return true;
		}
		return false;
	}
}

