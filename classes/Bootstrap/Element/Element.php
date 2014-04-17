<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Bootstrap_Element_Element {

    protected $_attributes = array();

    protected $_template = NULL;

    protected $_prefix = '';

    protected $_children = array();

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

    public function add(Bootstrap_Element_Element $child){
        $child->prefix($this->prefix());

        $this->_children[] = $child;

        return $this;
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

    public function children($child_id = NULL){
        return is_null($child_id)
               ? $this->_children
               : Arr::get($this->_children, $child_id);
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


/*
    public function __get($column){
        return $this->get($column);
    }

    public function get($column)
    {
        if (array_key_exists($column, $this->_object))
        {
            return (in_array($column, $this->_serialize_columns))
                ? $this->_unserialize_value($this->_object[$column])
                : $this->_object[$column];
        }
        else
        {
            throw new Kohana_Exception('The :property property does not exist in the :class class',
                array(':property' => $column, ':class' => get_class($this)));
        }
    }
*/

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
} 