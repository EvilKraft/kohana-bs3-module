<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Datepicker extends Bootstrap_Element_Input{

    protected $_label = NULL;

    public function __construct(array $attributes = array(), $template = NULL){
        $this->_attributes['readonly'] = 'readonly';

        parent::__construct($attributes, $template);

        $this->addClass('datepicker');
        $this->addStyle('cursor: pointer');
    }

    public function label($title = NULL, array $attributes = array()){
        if(is_null($title)){
            return (string) $this->_label;
        }else{
            $attributes['for'] = $this->attributes('id');

            $this->_label = Bootstrap_Element::factory('Label', $attributes)
                ->title($title);

            return $this;
        }
    }
}