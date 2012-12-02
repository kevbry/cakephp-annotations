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
	
	public function invokeAnnotations()
	{
		foreach($this->annotations as $annotation)
		{
			$this->invokeEach($annotation);
		}
	}
	
	protected function invokeEach(Annotation $annotation);
}

?>
