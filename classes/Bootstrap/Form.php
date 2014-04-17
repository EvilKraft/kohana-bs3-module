<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Form extends Bootstrap_Element_Element {

    protected $_children = array();

    public function __construct(array $attributes = array(), $template = NULL){
        parent::__construct($attributes, $template);

        $this->_attributes['role'] = 'form';

        $prefix = Arr::get($this->attributes(), 'id', '');
        if($prefix != ''){
            $prefix .= '_';
        }
        $this->_prefix = $prefix;
    }

    public function add(Bootstrap_Element_Element $child){
        $child->prefix($this->prefix());

        $this->_children[] = $child;

        return $this;
    }

    public function children($child_id = NULL){
        return is_null($child_id)
            ? $this->_children
            : Arr::get($this->_children, $child_id);
    }
} 