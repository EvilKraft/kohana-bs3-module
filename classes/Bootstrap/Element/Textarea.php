<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Textarea extends Bootstrap_Element{

    protected $_text  = NULL;
    protected $_label = NULL;

    public function __construct(array $attributes = array(), $template = NULL){
        $this->_attributes['rows'] = 10;

        parent::__construct($attributes, $template);

        $this->addClass('form-control');
    }

    public function text($text = NULL){
        if(func_num_args() == 0){
            return $this->_text;
        }else{
            $this->_text = (string) $text;
            return $this;
        }
    }

    public function label($title = NULL, array $attributes = array()){
        if(func_num_args() == 0){
            return (string) $this->_label;
        }else{
            $attributes['for'] = $this->attributes('id');

            $this->_label = Bootstrap_Element::factory('Label', $attributes)
                ->title($title);

            return $this;
        }
    }

    //
    // TODO
    // Label not work with TinyMSE
    //
    public function prefix($prefix = NULL){
        if(is_null($prefix)){
            return $this->_prefix;
        }else{
            $this->_prefix = (string) $prefix;

            if($this->_real_id != ''){
                $this->_attributes['id'] = $this->_prefix . $this->_real_id;

                if(isset($this->_label) && $this->_label instanceof Bootstrap_Element_Label){
                    $this->_label->for = $this->id;
                }
            }
        }
    }
}