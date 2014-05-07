<?php defined('SYSPATH') or die('No direct script access.');

class Bootstrap_Helper {

    /**
     * @param array $attributes     html attributes
     * @param array $options        available options
     * @param array $selected       selected option string, or an array of selected options
     * @param null  $empty_option   text for empty option, or array('key' => 'text')
     * @param bool  $combine        use array values as option values <option value="arr_value">arr_value</option>
     * @return string
     * @throws Kohana_Exception
     */
    public static function select(array $attributes, array $options=array(), $selected=array(), $empty_option=NULL, $combine=FALSE){
        if(!array_key_exists('name', $attributes)){
            throw new Kohana_Exception('"name" attribute is required');
        }

        if (is_array($selected)){
            $attributes[] = 'multiple';
        }else{
            $selected = array((string) $selected);
        }

        $result = is_array($empty_option)
            ? '<option value="'.key($empty_option).'">'.(string) current($empty_option).'</option>'
            : '<option value="">'.(string) $empty_option.'</option>';

        if($combine){
            $options = array_combine($options, $options);
        }

        $selected_valid = array();

        $prepare_option = function($value, $text) use ($selected, &$selected_valid){
            $value = (string) $value;

            $attributes = array('value' => $value);

            if(in_array($value, $selected, TRUE)){
                $attributes[] = 'selected';

                $selected_valid[] = $value;
            }

            return '<option'.HTML::attributes($attributes).'>'.HTML::chars($text, FALSE).'</option>';
        };

        foreach ($options as $value => $text){
            if (is_array($text)){
                $grp_attributes = array('label' => $value);
                $grp_options    = '';

                foreach ($text as $_value => $_text) {
                    $grp_options .= $prepare_option($_value, $_text);
                }

                $result .= '<optgroup'.HTML::attributes($grp_attributes).'>'.$grp_options.'</optgroup>';
            }else{
                $result .= $prepare_option($value, $text);
            }
        }

        $selected_wrong = array_diff($selected, $selected_valid);
        if(count($selected_wrong) > 0){
            throw new Kohana_Exception('Wrong selected options: "'.implode('", "', $selected_wrong).'"!');
        }

        return '<select'.HTML::attributes($attributes).'>'.$result.'</select>';
    }

	public static function years_array($year = NULL) {
        if(is_null($year)){
            $year = date("Y")+1;
        }

		return range($year, 1960);
	}

	public static function str_to_mysql_date($str, $delimeter) {
		$str = trim($str);

		return ($str !== '') ? implode('-', array_reverse(explode($delimeter, $str))) : 0;
	}

	public static function str_to_timestamp($str, $hour = 0, $minute = 0, $second = 0) {
		$str = trim($str);

		return ($str !== '')
			? mktime($hour, $minute, $second, substr($str, 3,2), substr($str, 0,2), substr($str, 6,4))
			: 0;
	}
}