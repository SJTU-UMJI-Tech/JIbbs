<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Front_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct()
    {
        parent::__construct();
        //$this->load->model('site_model');
        $this->load->model('module_model');
    } 
	
	public function index()
	{
		$data['site_title'] = '首页';
		$data['module_name_array'] = json_encode($this->module_model->get_module_arr());
		$data['module_now'] = 0;
		$this->load->view('home', $data);
	}
	
	public function topic()
	{
		$data['id'] = $id;
		$this->load->view('topic', $data);

		
	}
}
