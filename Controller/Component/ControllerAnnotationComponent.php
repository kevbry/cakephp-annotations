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
		debug("In initialize");
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_INITIALIZE);
	}
	
	public function startup(Controller $controller)
	{
		debug("In startup");
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_STARTUP);
	}
	
	public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true)
	{
		debug("In beforeRedirect");
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_BEFOREREDIRECT);
	}
	
	public function beforeRender(Controller $controller)
	{
		debug("In beforeRender");
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_BEFORERENDER);
	}
	
	public function shutdown(Controller $controller)
	{
		debug("In shutdown");
		$this->runAnnotations(ComponentCallbacksAnnotationFilter::STAGE_SHUTDOWN);
	}
	
	public function runAnnotations($stage)
	{
		if(in_array($stage, $this->enable_for_stages))
		{
			$filter = new ComponentCallbacksAnnotationFilter($stage);
			$this->annotation_invoker->invokeAnnotations($filter);
		}
	}
}

?>
