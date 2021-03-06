<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Bootstrap_Abstract {

    protected $_attributes = array();

    protected $_template = NULL;

    protected $_prefix = '';

    protected $_real_id = '';

    protected $_required_attributes = array('name');

    final public static function factory($class_name, array $attributes = array(), $template = NULL){

        $called_class = get_called_class();

        if(get_parent_class($called_class) != 'Bootstrap_Abstract'){
            throw new Kohana_Exception('Method "factory" not allowed in class "'.$called_class.'"!');
        }

        $class = $called_class.'_'.ucfirst(strtolower($class_name));

        return new $class($attributes, $template);
    }

    public function __construct(array $attributes = array(), $template = NULL){
        $this->checkAttributes($attributes);

        $this->_attributes['id'] = Arr::get($attributes, 'name');

        $this->_attributes = Arr::merge($this->_attributes, $attributes);


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

                if(isset($this->_label) && $this->_label instanceof Bootstrap_Element_Label){
                    $this->_label->for = $this->id;
                }
            }
        }
    }

    public function attributes($attribute = NULL){
        return is_null($attribute)
               ? $this->_attributes
               : Arr::get($this->_attributes, $attribute);
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

    public function render_to_file($filename){
        $dir = dirname($filename);

        if(!is_writable($dir)){
            throw new Kohana_Exception('Directory "'.$dir.'" is not writable.');
        }

        file_put_contents($filename, $this->render(), LOCK_EX);
    }

    public function addClass($class){
        $class_a = explode(' ', $this->attributes('class'));

        $class_a[] = (string) $class;

        //Remove an empty array elements
        $class_a = array_diff($class_a, array(''));

        $this->_attributes['class'] = implode(' ', $class_a);

        return $this;
    }

    public function delClass($classes){
        if(!is_array($classes)){
            $classes = array($classes);
        }

        $class_a = explode(' ', $this->attributes('class'));
        $class_a = array_flip($class_a);

        foreach($classes as $class){ unset($class_a[$class]); }

        $class_a = array_keys($class_a);

        $this->_attributes['class'] = implode(' ', $class_a);

        return $this;
    }

    public function hasClass($class){
        $class_a = explode(' ', $this->attributes('class'));

        return in_array($class, $class_a);
    }

    public function addStyle($style){
        $styles = explode(';', $this->attributes('style'));
        $style  = explode(';', $style);

        $styles = array_merge ($styles, $style);

        //Remove an empty array elements
        $styles = array_diff($styles, array(''));

        $this->_attributes['style'] = implode(';', $styles).';';

        return $this;
    }

    protected function checkAttributes(Array $attributes){

        $res_array = array_diff($this->_required_attributes, array_keys($attributes));

        if(count($res_array) > 0){
            throw new Kohana_Exception('Class "'.get_class($this).'" is require attributes: "'.implode('","', $res_array).'".');
        }

        return true;
    }

    public function __toString(){
        return $this->render();
    }

    public function __isset($attribute){
        return isset($this->_attributes[$attribute]);
    }

    public function __unset($attribute){
        unset($this->_attributes[$attribute]);
    }


    public function __set($attribute, $value){
		$this->set($attribute, $value);
	}

    public function set($attribute, $value){
        $this->_attributes[$attribute] = $value;

        return $this;
    }


    public function __get($attribute){
		return $this->attributes($attribute);
	}

} 