<?php defined('SYSPATH') OR die('No direct script access.');


class Bootstrap {

    public static function factory($model)
    {
        if (is_string($model)) {
            $model = ORM::factory($model);
        }

        $form = new Bootstrap_Formold();

        return $form->load($model);
    }

    public function render_to_file($filename){
        $dir = dirname($filename);

        if(!is_writable($dir)){
            throw new Kohana_Exception('Directory "'.$dir.'" is not writable.');
        }

        file_put_contents($filename, $this->render(), LOCK_EX);
    }

    public function Hidden($name, $value = NULL, array $attributes = NULL){
        $attributes['type'] = 'hidden';

        return Form::input($name, $value, $attributes);
    }

    public function AdvancedInput($name, $value = NULL, array $attributes = NULL, $label = NULL, $help = NULL){
        $help  = is_null($help)?'':$this->HelpBlock($help);

        $res = '<div class="form-group">'
                    .$this->Label($name, $label)
                    .'<div>'
                        .$this->Input($name, $value, $attributes)
                        .$help
                    .'</div>
                </div>';

        return $res;
    }

    public function Input($name, $value = NULL, array $attributes = NULL){
        if (!isset($attributes['type'])){
            // Default type is text
            $attributes['type'] = 'text';
        }

        $attributes['id'] = $name;
        $attributes['name'] = $name;    // Set the input name
        $attributes['value'] = $value;  // Set the input value

        $attributes['placeholder'] = $name;
        $attributes['class']       = Arr::get($attributes, 'class', '').' form-control';

        return '<input '.HTML::attributes($attributes).'>';
    }

    public function Label($input, $text = NULL, array $attributes = NULL){
        if (is_null($text)) {
            // Use the input name as the text
            $text = ucwords(preg_replace('/[\W_]+/', ' ', $input));
        }

        $attributes['for']   = $input;          // Set the label target
        $attributes['class'] = 'control-label';

        return '<label'.HTML::attributes($attributes).'>'.$text.'</label>';


       // return Form::label($input, $text, $attributes);
    }

    public function HelpBlock($text, array $attributes = NULL){
        $attributes['class'] = 'help-block';

        return '<p '.HTML::attributes($attributes).'>'.$text.'</p>';
    }

    public function Textarea($name, $value = '', array $attributes = NULL, $double_encode = TRUE)
    {
        // Set the input name
        $attributes['id']    = $name;
        $attributes['name']  = $name;
        $attributes['class'] = 'form-control';
        $attributes['rows']  = '10';

        return '<textarea'.HTML::attributes($attributes).'>'.HTML::chars($value, $double_encode).'</textarea>';
    }

    public function AdvancedTextarea($name, $value = '', array $attributes = NULL, $label = NULL, $help = NULL){
        $help  = is_null($help)?'':$this->HelpBlock($help);

        $res = '<div class="form-group">'
                    .$this->Label($name, $label)
                    .'<div>'
                        .$this->Textarea($name, $value, $attributes)
                        .$help
                    .'</div>
                </div>';

        return $res;
    }

    public function Datepicker($name, $value = NULL, array $attributes = NULL, $label = NULL, $help = NULL){
        $attributes['readonly'] = 'readonly';
        $attributes['style']    = 'cursor: pointer;';
        $attributes['class']    = 'datepicker';

        $help  = is_null($help)?'':$this->HelpBlock($help);

        $res = '<div class="form-group">'
                    .$this->Label($name, $label)
                    .'<div>'
                        .'<div class="input-group">'
                            .$this->Input($name, $value, $attributes)
                            .'<label for="'.$name.'" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span></label>'
                        .'</div>'
                        .$help
                    .'</div>
                </div>';

        return $res;
    }
} 