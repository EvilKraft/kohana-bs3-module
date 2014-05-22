<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_FormBuilder  {

    protected $_model;

    protected $_form;

    public static function factory($model, $form = 'basic')
    {
        if (is_string($model)) {
            $model = ORM::factory($model);
        }

        $form = 'Bootstrap_Form_'.ucfirst(strtolower($form));
        $form = new $form(array(
            'name' => 'frm_'.$model->object_name()
        ));

        return new Bootstrap_FormBuilder($model, $form);
    }

    public function __construct(ORM $model, Bootstrap_Form $form){
        $this->_model = $model;
        $this->_form  = $form;

        $this->fillForm();

        $this->_form
            ->add(
                Bootstrap_Element::factory('Button', array('type' => 'submit'))
                    ->text('Submit')
                    ->setOption('success')
            )->add(
                Bootstrap_Element::factory('Button')
                    ->text('Cancel')
            );
    }

    protected function fillForm(){
        foreach($this->_model->table_columns() as $field){
            $attributes = array(
                'name'  => $field['column_name'],
                'value' => $this->_model->$field['column_name']
            );

            if($field['key'] == 'PRI'){
                $element = Bootstrap_Element::factory('Hidden', $attributes);
            }elseif(in_array($field['type'], array('int', 'float'))){
                //data_type: tinyint, smallint, int, bigint [unsigned [zerofill]]
                //data_type: decimal, float, double [unsigned [zerofill]]
                //
                // bool, boolean is just tinyint(1) :(

                $element = Bootstrap_Element::factory('Input', $attributes)
                    ->label($attributes['name']);
            }else{
                switch($field['data_type']){
                    case 'char'      :
                    case 'varchar'   :
                        $attributes['maxlength'] = $field['character_maximum_length'];
                        $element = Bootstrap_Element::factory('Input', $attributes)
                            ->label($attributes['name']);
                        break;
                    case 'tinytext'  :
                    case 'text'      :
                    case 'mediumtext':
                    case 'longtext'  :
                        unset($attributes['value']);

                        $attributes['maxlength'] = $field['character_maximum_length'];

                        $element = Bootstrap_Element::factory('Textarea', $attributes)
                            ->label($attributes['name'])
                            ->text($this->_model->$field['column_name']);
                        break;
                    case 'date'      :
                        if(!is_null($attributes['value'])){
                            $date = new DateTime($attributes['value']);
                            $attributes['value'] = $date->format('d.m.Y');
                        }

                        $element = Bootstrap_Element::factory('Datepicker', $attributes)
                            ->label($attributes['name']);
                        break;
                    case 'datetime'  :
                    case 'timestamp' :
                        if(!is_null($attributes['value'])){
                            $date = new DateTime($attributes['value']);
                            $attributes['value'] = $date->format('d.m.Y H:i:s');
                        }

                        $element = Bootstrap_Element::factory('Datetimepicker', $attributes)
                            ->label($attributes['name']);
                        break;
                    case 'time'      :
                        $element = Bootstrap_Element::factory('Timepicker', $attributes)
                            ->label($attributes['name']);
                        break;
                    case 'enum'      :
                        unset($attributes['value']);

                        $element = Bootstrap_Element::factory('Select', $attributes)
                            ->label($attributes['name'])
                            ->options($field['options'], true);


                        $selected = (string) $this->_model->$field['column_name'];
                        if($selected != ''){
                            $element->selected($selected);
                        }
                        break;
                    case 'set'      :
                        unset($attributes['value']);

                        $element = Bootstrap_Element::factory('Select', $attributes)
                            ->label($attributes['name'])
                            ->options($field['options'], true);

                        $selected = (string) $this->_model->$field['column_name'];
                        if($selected != ''){
                            $element->selected(explode(',', $selected));
                        }
                        break;
                    case 'year'      :
                        unset($attributes['value']);

                        $element = Bootstrap_Element::factory('Select', $attributes)
                            ->label($attributes['name'])
                            ->options(Bootstrap_Helper::years_array(), true);

                        if($this->_model->$field['column_name'] != '0000'){
                            $element->selected($this->_model->$field['column_name']);
                        }
                        break;
                    case 'binary'    :
                    case 'varbinary' :
                    case 'tinyblob'  :
                    case 'blob'      :
                    case 'mediumblob':
                    case 'longblob'  :
                        // TODO: Binary fields

                        $element = Bootstrap_Element::factory('HelpBlock')
                            ->addStyle('color: red;')
                            ->text('Can\'t show field "'.$field['column_name'].'".<br>Module not work with binary fields.');
                        break;
                    default :
                        //echo 'zz'.Debug::vars($this->_model->$field['column_name'], $field).'dd';
                        echo '<pre>Unknown field<br>value => '.$this->_model->$field['column_name'].'<br>'.print_r($field, true).'</pre>';
                }
            }

            if($element instanceof Bootstrap_Element){
                $this->_form->add($element);
            }
        }

        return $this;
    }

    public function render(){
        return $this->_form->render();
    }
} 