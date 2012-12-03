<?php

App::build(array(
	'Annotation'=>'%s'.'Annotation'.DS,
	'Engine'=>'%s'.'Engine'.DS,
	'Filter'=>'%s'.'Filter'.DS,
	'Invoker'=>'%s'.'Invoker'.DS
), App::REGISTER);

/**

 * WANT:

 * -Read annotations from controller method when it is run
 *	-Run the invoke() method of each annotation, passing in the Controller instance it was attached to
 */