<?php
App::uses('AnnotationFilter', 'Filter');
App::uses('ComponentCallbacksFilterableAnnotation', 'Filter');

/**
 * AnnotationFilter which returns only those annotations marked as being runnable at the given stage
 *
 * @author kevbry
 */
class ComponentCallbacksAnnotationFilter implements AnnotationFilter
{
	const STAGE_INITIALIZE="initialize";
	const STAGE_STARTUP="startup";
	const STAGE_BEFORERENDER="beforeRender";
	const STAGE_SHUTDOWN="shutdown";
	const STAGE_BEFOREREDIRECT="beforeRedirect";
	
	protected $stage;
	
	/**
	 * 
	 * @param type $stage The stage which all returned annotations must have
	 */
	public function __construct($stage=self::STAGE_INITIALIZE)
	{
		$this->stage = $stage;
	}
	
	/**
	 * Returns only those annotations marked as enabled for this stage
	 * @param array $annotations of ComponentCallbacksFilterableAnnotation
	 */
	public function apply($annotations)
	{
		$passed = array();
		foreach($annotations as $annotation)
		{
			if($annotation instanceof ComponentCallbacksFilterableAnnotation && $annotation->runForStage($this->stage))
			{
				$passed[] = $annotation;
			}
		}
		return $passed;
	}
}

