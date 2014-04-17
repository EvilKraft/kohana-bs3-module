<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Form extends Bootstrap_Element_Element {

    public function __construct(array $attributes = array(), $template = NULL){
        parent::__construct($attributes, $template);

        $this->_attributes['role'] = 'form';

        $prefix = Arr::get($this->attributes(), 'id', '');
        if($prefix != ''){
            $prefix .= '_';
        }
        $this->_prefix = $prefix;
    }
} 