CakePHP Annotations
===================================

A project to enable automatic annotations processing as part of the Cake controller lifecycle.

To use, add as a submodule in your app's plugins directory:

`git submodule add git://github.com/kevbry/cakephp-annotations.git app/Plugin/Annotations`

then enable the plugin in your bootstrap.php

`CakePlugin::load('Annotations')`

and enable the Component for your controller:

    //Set disable to true to disable annotations runner`
    public $components = array('Annotations.ControllerAnnotation'=>array('disable'=>false)); 

You can use the built-in ParamConverterAnnotation to work some magic on your controller method parameters


    App::uses('ParamConverterAnnotation', 'Annotations.Annotation');
    //...

    /**
    * @ParamConverterAnnotation(parameter='list_item', class='ListItem', method='findById')
    */
    public function view($list_item=1)
    {
        //debug($list_item)
        //Will contain the results of calling findById on the ListItem controller property 
        //(model) with the original value of $list_item from the request, or its default value, 
        //if no parameter was in the request. A NotFoundException is thrown if no result is returned
        //ie $list_item = $this->ListItem->findById($list_item);
    }


ParamConverterAnnotation will always run at the "startup" phase of the component lifecycle. For most annotations, you can specify an extra property "stage" as a string or array of strings specifying the component stages at which the annotation will be invoked, the default being "initialize".

Have a look at ParamConverterAnnotation to get an idea of how to write your own annotations, or at the [Example project](https://github.com/kevbry/cakephp-annotations-example) for more ideas.
