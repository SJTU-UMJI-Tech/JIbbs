<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('topic_model');
        $this->load->model('user_model');
    }
	
	public function _remap($username)
	{
		$data['site_title'] = $username;
		$this->load->view('member', $data);
		
		
	}
}

?>