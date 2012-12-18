<?php
App::uses('ControllerActionAnnotation', 'Annotation');

/**
 * @name ParamConverter
 * 
 * Fill controller method parameters with useful values
 * Default value for 'method' is findById
 * Default value for 'continueOnMissing' is false (throw exception if no object returned)
 * 
 * @example  
 *		'@ParamConverter(parameter='id',method='findById',class='Widget',continue_on_missing=false)'
 *		public function view($id)
 *		{ .. }
 *		On requesting /widgets/view/2
 *		$id will be filled with the result of calling $controller->Widget->findById(2)
 *		If no result is returned from calling the specified function, a NotFoundException is thrown
 *
 * @author kevbry
 */
class ParamConverter extends ControllerActionAnnotation
{
	public $method="findById"; //The name of the method to call to get the object
	public $parameter=null; //The name of the parameter
	public $class=null; //The class to call the callback on
	public $continue_on_missing=false;//Whether to throw an exception if no value is returned
	public $require_value=true; //Whether to throw an exception if parameter was not provided in URL and no default value is set
	
	
	/**
	 * 
	 * @param String $method The name of the method to call on $class (default findById)
	 * @param String $parameter The name of the method parameter to replace
	 * @param String $class The name of the controller property to call the method on
	 * @param boolean $continue_on_missing If true, do not throw an exception if nothing is returned by param conversion (default false)
	 * @param boolean $require_value Whether to throw an exception if parameter was not provided in URL and no default value is set (default true)
	 * @throws InvalidArgumentException If the specified method does not exist on $class
	 * @throws NotFoundException If no results are returned from method call
	 */
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
					else if($this->require_value)
					{
						throw new InvalidArgumentException("Parameter {$this->parameter} is required");
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
	
	/**
	 * Only run this Annotation at the startup stage (post-beforeFilter)
	 */
	public function runForStage($stage)
	{
		if($stage == ComponentCallbacksAnnotationFilter::STAGE_STARTUP)
		{
			return true;
		}
		return false;
	}
}

