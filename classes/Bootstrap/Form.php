<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Form extends Bootstrap_Element_Element {

    public function content(){
        foreach($this->_children as $child){
            $this->_content .= (string) $child;
        }

        return $this->_content;
    }

} 