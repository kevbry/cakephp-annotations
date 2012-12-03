<?php
App::uses("AnnotationFilter", "Annotations.Filter");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BeforeInitializeAnnotationFilter
 *
 * @author kevinb
 */
class ComponentCallbacksAnnotationFilter implements AnnotationFilter
{
	const STAGE_INITIALIZE="initialize";
	const STAGE_STARTUP="startup";
	const STAGE_BEFORERENDER="beforeRender";
	const STAGE_SHUTDOWN="shutdown";
	const STAGE_BEFOREREDIRECT="beforeRedirect";
	
	protected $stage;
	public function __construct($stage=self::STAGE_INITIALIZE)
	{
		$this->stage = $stage;
	}
	
	/**
	 * 
	 * @param type $annotations array of ControllerActionAnnotations
	 */
	public function apply($annotations)
	{
		$passed = array();
		foreach($annotations as $annotation)
		{
			if($annotation instanceof ControllerActionAnnotation && $annotation->runForStage($this->stage))
			{
				$passed[] = $annotation;
			}
		}
		return $passed;
	}
}

?>
