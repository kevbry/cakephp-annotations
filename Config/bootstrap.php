<?php

App::build(array(
	'Annotation'=>array('%s'.'Annotation'.DS, App::pluginPath("Annotations") . 'Annotation' . DS),
	'Engine'=>array('%s'.'Engine'.DS, App::pluginPath("Annotations") . 'Engine' . DS),
	'Filter'=>array('%s'.'Filter'.DS, App::pluginPath("Annotations") . 'Filter' . DS),
	'Invoker'=>array('%s'.'Invoker'.DS, App::pluginPath("Annotations") . 'Invoker' . DS)
), App::REGISTER);

if(!Configure::read("Annotations.default_engine"))
{
	Configure::write("Annotations.default_engine", "AddendumAnnotationEngine");
}
