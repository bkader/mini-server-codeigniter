<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('return_json'))
{
    /**
     * Outputs anything in JSON format
     *
     * @access   public
     * @param    mixed
     * @param    boolean
     * @return   string
     */
	function return_json($str, $b = false)
	{
        // If b (beautify is set to true)
        $str = ($b === true) ? beautify_json($str) : json_encode($str);
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo $str;
	}
}

if ( ! function_exists('beautify_json'))
{
    /**
     * Makes the json encoded string human-readable
     *
     * @access 	public
     * @param 	mixed
     * @return 	string
     */
    function beautify_json($str = false)
    {
        // make sure array is provided
        if ( ! $str or empty($str))
        	return null;

        //Encode the string
        $json = json_encode($str);

        $result        = '';
        $pos           = 0;
        $str_len       = strlen($json);
        $indent_str    = '  ';
        $new_line      = "\n";
        $prev_char     = '';
        $out_of_quotes = true;

        for ($i = 0; $i <= $str_len; $i++)
        {
            // grab the next character in the string
            $char = substr($json, $i, 1);

            // are we inside a quoted string?
            if ($char == '"' and $prev_char != '\\')
            {
                $out_of_quotes = !$out_of_quotes;
            }
            // if this character is the end of an element, output a new line and indent the next line
            elseif (($char == '}' or $char == ']') and $out_of_quotes)
            {
                $result .= $new_line;
                $pos--;

                for ($j = 0; $j < $pos; $j++)
                {
                    $result .= $indent_str;
                }
            }

            // add the character to the result string
            $result .= $char;

            // if the last character was the beginning of an element, output a new line and indent the next line
            if (($char == ',' or $char == '{' or $char == '[') and $out_of_quotes)
            {
                $result .= $new_line;

                if ($char == '{' or $char == '[')
                {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++)
                {
                    $result .= $indent_str;
                }
            }

            $prev_char = $char;
        }

        // return result
        return $result.$new_line;
    }
}

/* End of file json_helper.php */
/* Location: ./system/helpers/json_helper.php */