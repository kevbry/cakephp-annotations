<?php

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
	protected $stage;
	public function __construct($stage="initialize")
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
			if($annotation instanceof ControllerActionAnnotation && $annotation->runForStage($stage))
			{
				$passed[] = $annotation;
			}
		}
	}
}

?>
