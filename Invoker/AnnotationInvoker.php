<?php
/**
 * Description of AnnotationInvoker
 *
 * @author kevinb
 */
abstract class AnnotationInvoker
{	
	protected $annotations;
	
	
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
	
	protected function invokeAnnotation(Annotation $annotation);
}

?>
