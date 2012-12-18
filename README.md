CakePHP Annotations
===================================

A project to enable automatic annotations processing as part of the Cake controller lifecycle.

By default, this project uses the [addendum annotations engine](http://code.google.com/p/addendum/). To use your own, simply add it to Vendors and write a driver for it following the conventions in Engine/AnnotationEngine.php
The system requires a lot of addendum conventions for annotations as I found them the most sensible.

## Install and enable

To use, add as a submodule in your app's plugins directory:

`git submodule add git://github.com/kevbry/cakephp-annotations.git app/Plugin/Annotations`

then enable the plugin in your bootstrap.php

`CakePlugin::load('Annotations', array('bootstrap'=>true));`

and enable the Component for your controller:

    public $components = array('Annotations.ControllerAnnotation'=>array()); 

## Component settings

There are two configuration options for the ControllerAnnotation component:
- `disable`, a boolean telling the component to not run annotations
- `engine`, the class name of the AnnotationEngine subclass to use.
	- The system-wide AnnotationEngine to use can be configured in core with `Configure::write("Annotations.default_engine", "EngineName");`


## Annotation basics

All current annotations are specializations of ControllerActionAnnotation, and have a few specific properties.
- Single valued annotations ( `@SingleValuedAnnotation('myValue')` ) have their values stored in the Annotation's "value" property.
- Multi valued annotations ( `@MultiValuedAnnotation(property1='val', property2='val2')` ) have their values stored in the matching properties on the Annotation.
	- For this example, in MultiValuedAnnotation, $this->property1 == 'val', $this->property2 == 'val2'
- Arrays can be set to either single or multi-valued properties
	- ie `@SingleValuedAnnotation({1,2,3})` or `@SingleValuedAnnotation({key1='val1', key2='val2'})`
- By default, all annotations run only at the "initialize" (pre-beforeFilter) controller lifecycle stage.
	- To run at any single stage, set the "stage" property of the annotation to the name of the stage ( `@SingleValuedAnnotation(value='myValue', stage='shutdown')` )
	- To run at multiple stages, set the "stage" property to an array of stages ( `@SingleValuedAnnotation(value='myValue', stage={'initialize', 'shutdown'})` )
	- If overriding the default stage of a single-valued annotation, you must set the "value" property manually, as above
	- Valid stages match the [Component api stage names](http://book.cakephp.org/2.0/en/controllers/components.html#component-api)

## Built-in annotations

### ParamConverter
ParamConverter is similar to Symfony ParamConverters; it allows you to map an identifier from the URL to an object in your system before the controller action is run.

Typical usage is as follows:

    App::uses('ParamConverterAnnotation', 'Annotation');
    //...

    /**
    * @ParamConverterAnnotation(parameter='list_item', class='ListItem', method='findById')
    */
    public function view($list_item=1)
    {
		//.. $list_item will contain the results of calling $this->ListItem-findById(1)
    }

ParamConverter will run at the startup (post-beforeFilter) stage of the controller lifecycle and call the provided method on the provided class with
the value of the given parameter from the URL if it is present, or the default value from the method signature. It has the following options:
<dl>
<dt>method</dt>
<dd>The name of the method to call on 'class'. Defaults to findById</dd>
<dt>parameter<dt>
<dd>The name of the controller method parameter whose value should be replaced</dd>
<dt>class</dt>
<dd>The controller class member to call 'method' on</dd>
<dt>continue_on_missing</dt>
<dd>Defaults to false. If false, throw a NotFoundException when no results are returned from the call to 'method'</dd>
<dt>require_value<dt>
<dd>Defaults to true. If true, throw an InvalidArgumentException if there is no value for the parameter in the URL and no default value is present</dd>
</dl>

### NamedParamToArgument
NamedParamToArgument will map the values of named parameters in the URL (ie /controller/action/name1:value1/name2:value2) to the matching controller method arguments.

Typical usage is as follows:

    App::uses('NamedParamToArgument', 'Annotation');
    //...

    /**
    * @NamedParamToArgument
    */
    public function view($id=1,$type='Widget')
    {
		//.. For a request to /widgets/view/type:Foo/id:2, $id will be 2, $type will be 'Foo'
    }

NamedParamToArgument runs at the startup (post-beforeFilter) stage of the controller lifecycle. It has a few behaviours to make note of:
- Parameter order does not matter
- If a parameter has a default value and is not either a positional parameter in the URL or a named parameter, the default value will be used.
- If a parameter has both a positional parameter in the URL and a named parameter, the named parameter takes precedence
	- A request to /widgets/view/1/id:2 for a method with signature `view($id)` will result in $id having a value of 2
- If a parameter matches a positional parameter but not a named parameter, the positional parameter is used (default Cake behaviour)
	- A request to /widgets/view/1/5/id:2 for a method with signature `view($id,$value)` will result in $id == 2, $value == 5

### ControllerOptions
ControllerOptions allows you to set any controller parameters from an annotation

Typical usage is as follows:

    App::uses('ControllerOptions', 'Annotation');
    //...

    /**
    * @ControllerOptions({autoRender=false,ext='.twig'})
    */
    public function view($id=1)
    {
		//.. $this->autoRender == false, $this->ext == true
    }

ControllerOptions runs at the initialize (pre-beforeFilter) stage of the controller lifecycle. It simply sets the controller properties (keys) to the associated values.



## Good luck

Hopefully you find this project helpful. To have a look at a few of these annotations in use, check out [the cake-annotations-example project](https://github.com/kevbry/cakephp-annotations-example).

Have a read through the code; it's fairly heavily documented to help making you write your own annotations as easy as possible.



