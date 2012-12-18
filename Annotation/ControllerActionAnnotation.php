<?php
App::uses('ControllerCallbacksAnnotationFilter', 'Filter');
App::uses('CakeAnnotation', 'Annotation');
App::uses('ComponentCallbacksFilterableAnnotation', 'Filter');
/**
 * Base class for Controller action annotations
 *
 * @author kevbry
 */
abstract class ControllerActionAnnotation extends CakeAnnotation implements ComponentCallbacksFilterableAnnotation
{
	/**
	 *
	 * @var Mixed The component lifecycle stage at which this annotation should run. By default, only at initialize (pre-beforeFilter). May be single or array of stages.
	 */
	public $stage=ComponentCallbacksAnnotationFilter::STAGE_INITIALIZE;
	
	/**
	 * Called to run this annotation on an action ($controller->request->action)
	 * on the given controller
	 */
	abstract public function invoke(Controller $controller);
	
	
	/**
	 * 
	 * @param String $stage The current stage in the component lifecycle
	 * @return boolean True to have this annotation run at the given stage, false to ignore it
	 */
	public function runForStage($stage)
	{
		if(is_null($this->stage))
		{
			return true;
		}
		else if(is_array($this->stage))
		{
			return in_array($stage, $this->stage);
		}
		else
		{
			return $stage == $this->stage;
		}
	}
}
