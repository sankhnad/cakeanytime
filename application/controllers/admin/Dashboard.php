<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Dashboard extends CI_Controller {
	public
	function __construct() {
		parent::__construct();
	}

	public
	function index() {
		$data['activeMenu'] = 'dashboard';
		$data['totalCustomer'] = 10;
		$data['totalPendingKyc'] = 20;
		$this->load->view('admin/dashboard', $data);
	}
}