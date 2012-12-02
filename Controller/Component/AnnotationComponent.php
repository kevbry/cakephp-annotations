<?php
/**
 * Description of AnnotationComponent
 *
 * @author kevinb
 */
class AnnotationComponent extends Component
{
	public function __construct(\ComponentCollection $collection, $settings = array())
	{
		parent::__construct($collection, $settings);
	}
	
	public function initialize(\Controller $controller)
	{
		parent::initialize($controller);
	}
	
	public function startup(\Controller $controller)
	{
		parent::startup($controller);
	}
}

?>
