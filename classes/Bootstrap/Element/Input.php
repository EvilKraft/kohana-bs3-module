<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Input extends Bootstrap_Element_Element{

    protected $_label = NULL;

    public function content(){
        $this->_content = Form::input(Arr::get($this->_attributes, 'name'), Arr::get($this->_attributes, 'value'), $this->_attributes);

        return $this->_content;
    }

    public function label($title, array $attributes = array()){
        $attributes['title'] = $title;
        $attributes['for']   = Arr::get($this->_attributes, 'id');

        $this->_label = Bootstrap_Element_Label::factory($attributes);

        return $this;
    }
} 