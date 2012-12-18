<?php
/**
 * Component to allow Annotation parsing and invocation at points in the controller lifecycle
 *
 * @author kevbry
 */
App::uses('ControllerActionAnnotationInvoker', 'Invoker');
App::uses('ComponentCallbacksAnnotationFilter', 'Filter');

class ControllerAnnotationComponent extends Component
{	
	public $enabled=true;
	
	public $engine=null;
	
	private $engine_instance=null;
	
	public $annotation_invoker;
	
	public function __construct(\ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
		$controller=$collection->getController();
		if(isset($settings['disable']) && $settings['disable'])
		{
			$this->enabled=false;
		}
		if(isset($settings['engine']))
		{
			$this->engine = $settings['engine'];
		}
		if(isset($controller->disable_annotations) && $controller->disable_annotations)
		{
			$this->enabled=false;
		}
		if($this->enabled)
		{
			$annotation_engine = $this->getAnnotationEngine();
		
			$annotation_engine->readAnnotationsFromClass($controller);
		
			$annotations = $annotation_engine->annotationsForMethod($controller->request->action);
			
			$this->annotation_invoker = new ControllerActionAnnotationInvoker($controller, $annotations);	
		}
		
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
		if($this->enabled)
		{
			$filter = new ComponentCallbacksAnnotationFilter($stage);
			$this->annotation_invoker->invokeAnnotations($filter);
		}
	}
	
	protected function getAnnotationEngine()
	{
		if(is_null($this->engine_instance))
		{
			if(is_null($this->engine))
			{
				$engine = Configure::read('Annotations.default_engine');
				
				App::uses($engine, 'Engine');
				$this->engine_instance = new $engine;
			}
			else
			{
				App::uses($this->engine, "Engine");
				$this->engine_instance = new $this->engine;
			}
		}
		return $this->engine_instance;
		
	}
}

?>
