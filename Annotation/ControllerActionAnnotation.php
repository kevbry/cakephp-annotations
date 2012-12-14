<?php
App::uses("ControllerCallbacksAnnotationFilter", "Annotations.Filter");
/**
 * Description of ControllerActionAnnotation
 *
 * @author kevinb
 */
abstract class ControllerActionAnnotation extends Annotation implements ComponentCallbacksFilterableAnnotation
{
	public $value;
	public $stage=ComponentCallbacksAnnotationFilter::STAGE_INITIALIZE;
	
	abstract public function invoke(Controller $controller);
	
	
	//create an interface for this and use interface in filter instead of this class
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
