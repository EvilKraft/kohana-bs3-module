<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Form extends Bootstrap_Element_Element {

    public function content(){
        foreach($this->_data as $element){
            $this->_content .= (string) $element;
        }

        return $this->_content;
    }

} 