<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Element_Button extends Bootstrap_Element{

    protected $_text = NULL;

    protected $_required_attributes = array();

    protected static $available_options = array(
        'btn-default',
        'btn-primary',
        'btn-success',
        'btn-info',
        'btn-warning',
        'btn-danger',
        'btn-link'
    );

    protected static $available_sizes = array(
        '',
        'btn-lg',
        'btn-sm',
        'btn-xs',
    );

    public function __construct(array $attributes = array(), $template = NULL){
        $this->_attributes['type'] = 'button';

        parent::__construct($attributes, $template);

        $this->addClass('btn');
        $this->setOption('btn-default');
    }

    public function text($text = NULL){
        if(is_null($text)){
            return $this->_text;
        }else{
            $this->_text = (string) $text;
            return $this;
        }
    }

    public function setOption($option){
        if(substr($option, 0, 4) != 'btn-'){
            $option = 'btn-'.$option;
        }

        if(!in_array($option, self::$available_options)){
            throw new Kohana_Exception('Unknown option: "'.$option.'"!');
        }

        $this->delClass(self::$available_options);
        $this->addClass($option);

        return $this;
    }

    public function setSize($size){
        if($size != '' && substr($size, 0, 4) != 'btn-'){
            $size = 'btn-'.$size;
        }

        if(!in_array($size, self::$available_sizes)){
            throw new Kohana_Exception('Unknown size: "'.$size.'"!');
        }

        $this->delClass(self::$available_sizes);
        $this->addClass($size);

        return $this;
    }

    public function toggleBlock(){
        $class = 'btn-block';

        if($this->hasClass($class)){
            $this->delClass($class);
        }else{
            $this->addClass($class);
        }

        return $this;
    }
}