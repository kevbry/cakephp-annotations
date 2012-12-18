<?php

App::uses('AnnotationFilter', 'Filter');

/**
 * Handles invokation of runnable annotations
 *
 * @author kevbry
 */
abstract class AnnotationInvoker
{	
	protected $annotations=array();
	protected $engine;
	
	/**
	 * 
	 * @return AnnotationEngine
	 */
	public function getAnnotationEngine()
	{
		return $this->engine;
	}
	
	/**
	 * 
	 * @param AnnotationFilter $filter Filter to apply to reduce the set of annotations to run
	 */
	public function invokeAnnotations(AnnotationFilter $filter)
	{
		foreach($filter->apply($this->annotations) as $annotation)
		{
			$this->invokeAnnotation($annotation);
		}
	}
	
	/**
	 * Run a given annotation in the manner specific to a given annotation type
	 */
	abstract protected function invokeAnnotation($annotation);
}

