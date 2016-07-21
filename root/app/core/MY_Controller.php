<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	/**
	 * @var array - array to pass to view files
	 */
	public $data = array();

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
}

/* End of file MY_Controller.php */
/* Location: ./root/app/core/MY_Controller.php */