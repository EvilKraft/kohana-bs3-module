<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Label extends Bootstrap_Element_Element{

    protected $_title = NULL;

    public function title($title = NULL){
        if(is_null($title)){
            return $this->_title;
        }else{
            $this->_title = (string) $title;
            return $this;
        }
    }
}