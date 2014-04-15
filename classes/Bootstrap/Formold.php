<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_Formold extends Bootstrap {

    protected $_buffer    = '';
    protected $_is_opened = false;

    public function __construct($action = NULL, array $attributes = NULL){
        $this->_buffer .= $this->open($action, $attributes);
    }

    public function load(ORM $model){
        foreach($model->table_columns() as $field){
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

    public function add($type, $name, $value = NULL, array $attributes = NULL, array $options = NULL){
        $supported_types = array(
            'input',
            'hidden',
            'label',
            'help_block',
        );

        if(!in_array($type, $supported_types)){
            throw new Kohana_Exception('Type "'.$type.'" not supported!');
        }

        $this->elements[] = array(
            'type'       => $type,
            'name'       => $name,
            'value'      => $value,
            'attributes' => $attributes,
            'options'    => $options,
        );

        return $this;
    }


    public function clear(){
        $this->_buffer    = '';
        $this->_is_opened = false;
        return $this;
    }

    public function render(){
        $this->_buffer .= $this->close();

        $tmp = $this->_buffer;
        $this->clear();
        return $tmp;
    }

    protected function open($action = NULL, array $attributes = NULL){
        if($this->_is_opened){
            throw new Kohana_Exception('Form was already opened!');
        }

        $attributes['role']  = 'form';
        $result  = Form::open($action,$attributes);
        $result .= '<fieldset><legend>Form Name</legend>';
        $this->_is_opened = TRUE;

        return $result;
    }

    protected function close(){
        if(!$this->_is_opened){
            throw new Kohana_Exception('Form was not opened!');
        }

        return '</fieldset></form>';
    }
} 