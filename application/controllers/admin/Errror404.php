<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errror404 extends CI_Controller {
	public function index()
	{
		$this->load->view('admin/404');
	}
}
