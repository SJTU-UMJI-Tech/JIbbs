<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('module_model');
    }
	
	private function view($id)
	{
		$data['site_title'] = '模块';
		$module_name_array = $this->module_model->get_module_arr();
		$data['module_name_array'] = json_encode($module_name_array);
		if ($id == NULL)
		{
			$data['module_now'] = 1;
		}
		else if ($id < 1)
		{
			$data['module_now'] = 1;
		}
		else if ($id > count($module_name_array))
		{
			$data['module_now'] = count($module_name_array);
		}
		else
		{
			$data['module_now'] = $id[0];
		}
		$this->load->view('module', $data);
	}
	
	public function _remap($id)
	{
		$this->view($id);
	}
	
	
}

?>