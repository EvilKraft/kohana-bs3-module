<?php defined('SYSPATH') OR die('No direct script access.');

class Bootstrap_FormBuilder  {

    protected $_model;

    protected $_form;

    public static function factory($model, $form = 'Bootstrap_Form')
    {
        if (is_string($model)) {
            $model = ORM::factory($model);
        }

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
                Bootstrap_Element_Button::factory(array('type' => 'submit'))
                    ->text('Submit')
                    ->setOption('success')
            )->add(
                Bootstrap_Element_Button::factory()
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
                $this->_form->add(
                    Bootstrap_Element_Hidden::factory($attributes)
                );
            }else{
                switch($field['data_type']){
                    case 'int'       :
                    case 'tinyint'   :
                        $this->_form->add(
                            Bootstrap_Element_Input::factory($attributes)
                                ->label($attributes['name'])
                        );
                        break;
                    case 'char'      :
                    case 'varchar'   :
                        $attributes['maxlength'] = $field['character_maximum_length'];
                        $this->_form->add(
                            Bootstrap_Element_Input::factory($attributes)
                                ->label($attributes['name'])
                        );
                        break;
                    case 'text'      :
                    case 'tinytext'  :
                        $this->_form->add(
                            Bootstrap_Element_Textarea::factory($attributes)
                                ->label($attributes['name'])
                        );
                        break;
                    case 'date'      :
                        $attributes['value'] = implode('-', array_reverse(explode('-', $attributes['value'])));

                        $this->_form->add(
                            Bootstrap_Element_Datepicker::factory($attributes)
                                ->label($attributes['name'])
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

    public function render(){
        return $this->_form->render();
    }
} 