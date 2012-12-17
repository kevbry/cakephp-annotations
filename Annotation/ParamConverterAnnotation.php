<?php
App::uses("Annotation", "ControllerActionAnnotation");

/**
 * Description of ParamConverterAnnotation
 *
 * @author kevinb
 */
class ParamConverterAnnotation extends ControllerActionAnnotation
{
	public $method="findById"; //The name of the method to call to get the object
	public $parameter=null; //The name of the parameter
	public $class=null; //The class to call the callback on
	public $continue_on_missing=false;
	
	public function invoke(Controller $controller)
	{
		//Overwrite request parameters with an actual object
		//Takes name of parameter to replace and the name of the method to call to find its replacement
		$requested_action = $controller->request->action;
		$method = new ReflectionMethod($controller, $requested_action);
		$this->_required(array("parameter", "method", "class"));
		
		$index=0;
		foreach($method->getParameters() as $parameter)
		{
			if($parameter->getName() == $this->parameter)
			{
				$passed_value=null;
				if(!isset($controller->request->params['pass'][$index]))
				{
					if($parameter->isDefaultValueAvailable())
					{
						$passed_value = $parameter->getDefaultValue();
					}
				}
				else 
				{
					$passed_value = $controller->request->params['pass'][$index];
				}
				if(!method_exists($controller->{$this->class}, $this->method))
				{
					throw new InvalidArgumentException("Method {$this->method} does not exist on object Controller->{$this->class}");
				}
				$converted_value = $controller->{$this->class}->{$this->method}($passed_value);
				if((!$this->continue_on_missing) && (!isset($converted_value) || is_null($converted_value) || empty($converted_value)))
				{
					throw new NotFoundException("{$this->class} with ID {$passed_value} not found");
				}
				$controller->request->params['pass'][$index] = $converted_value;
				
			}
			$index++;
		}
	}
	
	private function _required($parameters=array())
	{
		foreach($parameters as $parameter)
		{
			if(!isset($this->{$parameter}) || is_null($this->{$parameter}))
			{
				throw new InvalidArgumentException("Annotation option '$parameter' must be set in ParamConverterAnnotation");
			}
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

