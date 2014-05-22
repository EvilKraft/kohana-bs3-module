<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Bootstrap_Element extends Bootstrap_Abstract{

    protected $_help_block = '';

    public function help_block($text = NULL, array $attributes = array()){
        if(is_null($text)){
            return (string) $this->_help_block;
        }else{
            $this->_help_block = Bootstrap_Element::factory('HelpBlock', $attributes)
                ->text($text);

            return $this;
        }
    }
}