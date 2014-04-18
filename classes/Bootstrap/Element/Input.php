<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Input extends Bootstrap_Element_Element{

    protected $_label = NULL;

    public function __construct(array $attributes = array(), $template = NULL){
        $this->_attributes['placeholder'] = Arr::get($attributes, 'name');

        parent::__construct($attributes, $template);

        $this->addClass('form-control');
    }

    public function label($title = NULL, array $attributes = array()){
        if(is_null($title)){
            return (string) $this->_label;
        }else{
            $attributes['for'] = Arr::get($this->_attributes, 'id');

            $this->_label = Bootstrap_Element_Label::factory($attributes)
                ->title($title);

            return $this;
        }
    }
}