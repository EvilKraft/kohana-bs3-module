<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_HelpBlock extends Bootstrap_Element_Element{

    protected $_text = NULL;

    protected $_required_attributes = array();

    public function __construct(array $attributes = array(), $template = NULL){
        parent::__construct($attributes, $template);

        $this->addClass('help-block');
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