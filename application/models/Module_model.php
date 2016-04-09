<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_model extends CI_Model
{
		
    function __construct()
    {
        parent::__construct();
		$this->load->library('module_obj');
    }
	
	public function get_module_arr()
	{
		$query = $this->db->get('bbs_module');
		$modules = $query->result_array();
        foreach ($modules as $module)
		{
            $data[$module['id']] = $module['name_ch'];
        }
        return $data;
	}
	
	public function get_module_by_id($id)
	{
		$query = $this->db->select('*')->from('bbs_module')->where('id', $id)->get();
		if ($query->num_rows() == 1)
		{
			return $query->row(0, 'Module_Obj');
		}
		$module = new Module_Obj('error');
		$module->set_error();
		return $module;
		
	}
}
