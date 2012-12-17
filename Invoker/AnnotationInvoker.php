<?php

App::uses("AddendumAnnotationEngine", "Annotations.Engine");

/**
 * Description of AnnotationInvoker
 *
 * @author kevinb
 */
abstract class AnnotationInvoker
{	
	protected $annotations=array();
	
	
	/**
	 * 
	 * @return \AnnotationEngine
	 */
	public function loadAnnotationEngine()
	{
		//Read the requested engine from config
		
		return new AddendumAnnotationEngine();
	}
	
	public function invokeAnnotations(AnnotationFilter $filter)
	{
		foreach($filter->apply($this->annotations) as $annotation)
		{
			$this->invokeAnnotation($annotation);
		}
	}
	
	abstract protected function invokeAnnotation($annotation);
}

?>
