<?php
App::uses('ControllerActionAnnotation', 'Annotation');

/**
 * Injects values of named parameters from URL into the matching method arguments
 * 
 * @example 
 *	'@NamedParamsToArgument'
 *	function view($id, $type) { ... }
 *	Request for /widgets/view/type:thing/id:1
 *	$id will have value 1, $type will have value 'thing'
 *
 * @author kevbry
 */
class NamedParamsToArgument extends ControllerActionAnnotation
{
	
	/**
	 * 
	 * @param None
	 */
	public function invoke(Controller $controller)
	{
		$requested_action = $controller->request->action;
		$method = new ReflectionMethod($controller, $requested_action);
		
		$named_params = $controller->request->params['named'];
		
		$index=0;
		foreach($method->getParameters() as $parameter)
		{
			//If there is a value in args[named] for this parameter, use it
			if(isset($named_params[$parameter->getName()]))
			{
				$controller->request->params['pass'][$index] = $named_params[$parameter->getName()];
			}
			else if(isset($controller->request->params['pass'][$index]))
			{
				//Value was present in URL but not as a named parameter
				//Handled by cake
			}
			else if($parameter->isDefaultValueAvailable())
			{
				//Value not present in URL
				//Insert default values, since the named parameters might have been after a parameter with no value
				$controller->request->params['pass'][$index] = $parameter->getDefaultValue();
			}
				
			
			$index++;
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

