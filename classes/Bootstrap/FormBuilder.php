<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_FormBuilder  {

    protected $_model;

    protected $_form;

    public static function factory($model, $form = 'Bootstrap_Form')
    {
        if (is_string($model)) {
            $model = ORM::factory($model);
        }

        $form = new $form;

        return new Bootstrap_FormBuilder($model, $form);
    }

    public function __construct(ORM $model, Bootstrap_Form $form){
        $this->_model = $model;
        $this->_form  = $form;
    }

    public function fillForm(){
        foreach($this->_model->table_columns() as $field){
            if($field['key'] == 'PRI'){
                $this->_buffer .= $this->hidden($field['column_name'], $model->$field['column_name']);
            }else{
                switch($field['data_type']){
                    case 'int'       :
                    case 'tinyint'   :
                        $this->_buffer .= $this->AdvancedInput(
                            $field['column_name'],
                            $model->$field['column_name'],
                            NULL,
                            Arr::get($model->labels(), $field['column_name'])
                        );
                        break;
                    case 'char'    :
                    case 'varchar' :
                        $this->_buffer .= $this->AdvancedInput(
                            $field['column_name'],
                            $model->$field['column_name'],
                            array(
                                'maxlength' => $field['character_maximum_length']
                            ),
                            Arr::get($model->labels(), $field['column_name'])
                        );
                        break;
                    case 'text'      :
                    case 'tinytext'  :
                        $this->_buffer .= $this->AdvancedTextarea(
                            $field['column_name'],
                            $model->$field['column_name']
                        );
                        break;
                    case 'date'      :
                        $this->_buffer .= $this->Datepicker(
                            $field['column_name'],
                            implode('-', array_reverse(explode('-', $model->$field['column_name']))),
                            NULL,
                            Arr::get($model->labels(), $field['column_name'])
                        );
                        break;

                    case 'datetime'  :
                    case 'timestamp' :
                    case 'time'      :
                    case 'year'      :
                    case 'enum'      :
                        break;
                    default :
                        echo 'Unknown field:<br /><pre>'.print_r($field, true).'</pre>';
                }
            }
        }

        return $this;
    }
} 