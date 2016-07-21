<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function index()
	{
		$this->load->view('welcome');
	}
}

/* End of file Welcome.php */
/* Location: ./root/modules/welcome/controllers/Welcome.php */