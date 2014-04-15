<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Bootstrap_Element_Element {

    protected $_attributes = array();

    protected $_template = NULL;

    protected $_content = NULL;

    protected $_data = array();

    public static function factory(array $attributes = array(), $template = NULL){
        $class = get_called_class();

        return new $class($attributes, $template);
    }

    public function __construct(array $attributes = array(), $template = NULL){
        $this->_attributes = Arr::merge($this->_attributes, $attributes);

        $this->_template = is_null($template)
                         ? View::factory(get_class($this))
                         : View::factory($template);
    }

    public function add(Bootstrap_Element_Element $data){
        $this->_data[] = $data;

        return $this;
    }

    public function attributes($attribut = NULL){
        return is_null($attribut)
               ? $this->_attributes
               : Arr::get($this->_attributes, $attribut);
    }

    public function content(){
        return $this->_content;
    }

    public function render() {
        $this->content();

        if( $this->_template instanceof View) {
            $this->_content = $this->_template->set(array(
                'element'   => $this,
//                'attributes' => $this->_attributes,
//                'content' => $this->_content,
            ))->render();
        }

        return (string) $this->_content;
    }

    public function __toString(){
        return (string) $this->render();
    }
} 