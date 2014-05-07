<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Datetimepicker extends Bootstrap_Element_Datepicker{

    public function __construct(array $attributes = array(), $template = NULL){
        parent::__construct($attributes, $template);

        $this->delClass('datepicker');
        $this->addClass('datetimepicker');
    }

}