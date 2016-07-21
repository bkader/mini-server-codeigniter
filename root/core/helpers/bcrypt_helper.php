<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('bcrypt_salt'))
{
	/**
	 * Generates a salt
	 * @return string
	 */
    function bcrypt_salt()
    {
        $CI =& get_instance();
        $CI->load->library('bcrypt');
        return $CI->bcrypt->get_salt();
    }
}

if ( ! function_exists('bcrypt_hash'))
{
	/**
	 * Encrypts a given password
	 * @param  string  $str  password
	 * @param  string $salt  salt
	 * @return string        hashed password
	 */
    function bcrypt_hash($password = null, $salt = false)
    {
        $CI =& get_instance();
        if(isset($password) && strlen($password) > 0)
        {
            $CI->load->library('bcrypt');
            return $CI->bcrypt->hash($password, $salt);
        }
        return null;
    }
}

if ( ! function_exists('bcrypt_check'))
{
	/**
	 * Compares between a password and a hashed one
	 * @param  string $str        password
	 * @param  string $hashed_str hashed password
	 * @return boolean            whether correct or not
	 */
    function bcrypt_check($password, $hashed)
    {
        $CI =& get_instance();
        $CI->load->library('bcrypt');
        return $CI->bcrypt->check($password, $hashed);
    }
}

/* End of file bcrypt_helper.php */
/* Location: ./system/helpers/bcrypt_helper.php */