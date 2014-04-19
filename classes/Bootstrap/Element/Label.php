<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Label extends Bootstrap_Element_Element{

    protected $_title = NULL;

    protected $_required_attributes = array();

    public function __construct(array $attributes = array(), $template = NULL){
        parent::__construct($attributes, $template);

        $this->addClass('control-label');
    }

    public function title($title = NULL){
        if(is_null($title)){
            return $this->_title;
        }else{
            $this->_title = (string) $title;
            return $this;
        }
    }
}