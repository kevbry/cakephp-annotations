<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerActionAnnotation
 *
 * @author kevinb
 */
abstract class ControllerActionAnnotation extends Annotation
{
	public $value;
	
	public function invoke(Controller $controller);
}
