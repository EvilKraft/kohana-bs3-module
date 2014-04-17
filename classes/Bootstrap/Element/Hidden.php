<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Hidden extends Bootstrap_Element_Element{

    protected $_text = NULL;

    public function __construct(array $attributes = array(), $template = NULL){
        parent::__construct($attributes, $template);

        $this->_attributes['type'] = 'hidden';
    }
}