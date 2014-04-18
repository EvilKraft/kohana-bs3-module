<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Textarea extends Bootstrap_Element_Input{

    protected $_text = NULL;

    public function __construct(array $attributes = array(), $template = NULL){
        $this->_attributes['rows'] = 10;

        Bootstrap_Element_Element::__construct($attributes, $template);

        $this->addClass('form-control');
    }

    public function text($text = NULL){
        if(is_null($text)){
            return $this->_text;
        }else{
            $this->_text = (string) $text;
            return $this;
        }
    }
}