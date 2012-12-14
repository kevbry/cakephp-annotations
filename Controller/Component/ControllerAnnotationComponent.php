<?php
/**
 * Description of AnnotationComponent
 *
 * @author kevinb
 */
App::uses('ControllerActionAnnotationInvoker', 'Annotations.Invoker');
App::uses("ComponentCallbacksAnnotationFilter", "Annotations.Filter");

class ControllerAnnotationComponent extends Component
{
	public $enable_for_stages = array(
		ComponentCallbacksAnnotationFilter::STAGE_INITIALIZE
			);
	public $annotation_invoker;
	
	public function __construct(\ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
		
		$this->annotation_invoker = new ControllerActionAnnotationInvoker($collection->getController());
	}
	
	public function initialize(Controller $controller)
	{
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_INITIALIZE);
	}
	
	public function startup(Controller $controller)
	{
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_STARTUP);
	}
	
	public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true)
	{
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_BEFOREREDIRECT);
	}
	
	public function beforeRender(Controller $controller)
	{
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_BEFORERENDER);
	}
	
	public function shutdown(Controller $controller)
	{
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_SHUTDOWN);
	}
	
	public function runAnnotations($stage)
	{
		$filter = new ComponentCallbacksAnnotationFilter($stage);
		$this->annotation_invoker->invokeAnnotations($filter);
	}
}

?>
