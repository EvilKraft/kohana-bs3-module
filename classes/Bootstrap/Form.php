<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Form extends Bootstrap_Abstract {

    protected $_children = array();
    protected $_buttons  = array();
    protected $_caption  = '';

    public function __construct(array $attributes = array(), $template = NULL){
        parent::__construct($attributes, $template);

        $this->_attributes['role'] = 'form';

        $prefix = $this->attributes('id');
        if($prefix != ''){
            $prefix .= '_';
        }
        $this->_prefix = $prefix;
    }

    public function add(Bootstrap_Element $child){
        $child->prefix($this->prefix());

        if($child instanceof Bootstrap_Element_Button){
            $this->_buttons[] = $child;
        }else{
            $this->_children[] = $child;
        }

        return $this;
    }

    public function children($child_id = NULL){
        return is_null($child_id)
            ? $this->_children
            : Arr::get($this->_children, $child_id);
    }

    public function buttons($button_id = NULL){
        return is_null($button_id)
            ? $this->_buttons
            : Arr::get($this->_buttons, $button_id);
    }

    public function caption($text = NULL){
       if(is_null($text)){
           return $this->_caption;
       }else{
           $this->_caption = '<legend>'.$text.'</legend>';
       }
    }
} 