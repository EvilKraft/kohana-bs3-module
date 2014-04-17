<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Bootstrap_Element_Element {

    protected $_attributes = array();

    protected $_template = NULL;

    protected $_prefix = '';

    protected $_real_id = '';

    protected $_help_block = '';

    public static function factory(array $attributes = array(), $template = NULL){
        $class = get_called_class();

        return new $class($attributes, $template);
    }

    public function __construct(array $attributes = array(), $template = NULL){
        $this->_attributes = $attributes;

        if(is_null($this->attributes('id'))){
            $this->_attributes['id'] = $this->attributes('name');
        }
        $this->_real_id = $this->attributes('id');


        $this->_template = is_null($template)
                         ? View::factory(get_class($this))
                         : View::factory($template);
    }

    public function prefix($prefix = NULL){
        if(is_null($prefix)){
            return $this->_prefix;
        }else{
            $this->_prefix = (string) $prefix;

            if($this->_real_id != ''){
                $this->_attributes['id'] = $this->_prefix . $this->_real_id;
            }
        }
    }

    public function attributes($attribut = NULL){
        return is_null($attribut)
               ? $this->_attributes
               : Arr::get($this->_attributes, $attribut);
    }

    public function real_id(){
        return $this->_real_id;
    }

    public function render() {
        // Remove empty elements from array
        $this->_attributes = array_diff($this->_attributes, array(''));

        $content = $this->_template instanceof View
                 ? $this->_template->set(array('element' => $this))->render()
                 : '';

        return $content;
    }

    public function __toString(){
        return $this->render();
    }

    public function addClass($class){
        $class_a = explode(' ', $this->attributes('class'));

        $class_a[] = (string) $class;

        //Remove an empty array elements
        $class_a = array_diff($class_a, array(''));

        $this->_attributes['class'] = implode(' ', $class_a);
    }

    public function delClass($class){
        $class_a = explode(' ', $this->attributes('class'));

        $class_a = array_flip($class_a);
        unset($class_a[$class]);
        $class_a = array_keys($class_a);

        $this->_attributes['class'] = implode(' ', $class_a);
    }

    public function help_block($text = NULL, array $attributes = array()){
        if(is_null($text)){
            return (string) $this->_help_block;
        }else{
            $this->_help_block = Bootstrap_Element_HelpBlock::factory($attributes)
                ->text($text);

            return $this;
        }
    }

    public function render_to_file($filename){
        $dir = dirname($filename);

        if(!is_writable($dir)){
            throw new Kohana_Exception('Directory "'.$dir.'" is not writable.');
        }

        file_put_contents($filename, $this->render(), LOCK_EX);
    }
} 