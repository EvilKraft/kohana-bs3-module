<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Label extends Bootstrap_Element_Element{

    public function content() {
        $this->_content = Form::label($this->get('for'), $this->get('title'), $this->attributes());

        return $this->_content;
    }
} 