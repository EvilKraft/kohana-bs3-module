<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Select extends Bootstrap_Element{

    protected $_options      = array();
    protected $_selected     = NULL;
    protected $_empty_option = NULL;


    protected $_label = NULL;

    public function __construct(array $attributes = array(), $template = NULL){
        //$this->_attributes['placeholder'] = Arr::get($attributes, 'name');

        parent::__construct($attributes, $template);

        $this->addClass('form-control');
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

    public function options(array $options = NULL, $combine=FALSE){
        if(is_null($options)){
            return $this->_options;
        }

        if($combine){
            $options = array_combine($options, $options);
        }

        $this->_options = $options;

        return $this;
    }

    public function selected($selected = NULL){
        if(func_num_args() == 0){
            return $this->_selected;
        }

        $this->_selected = $selected;

        return $this;
    }

    public function empty_option($empty_option = NULL){
        if(is_null($empty_option)){
            return $this->_empty_option;
        }

        $this->_empty_option = $empty_option;

        return $this;
    }

    public function select(){
        $select = '';

        try {
            $select = Bootstrap_Helper::select(
                $this->attributes(),
                $this->options(),
                $this->selected(),
                $this->empty_option()
            );
        } catch (Kohana_Exception $e) {
            $select = $e->getMessage();
        }

        return $select;

    }
}