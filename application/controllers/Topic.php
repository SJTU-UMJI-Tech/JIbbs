<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topic extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('topic_model');
        $this->load->model('user_model');
    }
	
	public function _remap($id, $num)
	{
		
		$data['topic_id'] = $id;
		$topic = $this->topic_model->get_topic_by_id($id);
		if ($topic->id == 0)
		{
			
		}
		else
		{
			//$user = $this->user_model->get_user_by_id($topic->user_id);
			$data['site_title'] = $topic->name;
			$data['user_name'] = $this->session->userdata('username');
			//$data['user_avatar'] = $user->avatar; 
			$data['reply_num'] = $topic->reply_num;
			if ($num == NULL)
			{
				$data['reply_now'] = 1;
			}
			else if ($num[0] < 1 || $num[0] > $topic->reply_num)
			{
				$data['reply_now'] = 1;
			}
			else
			{
				$data['reply_now'] = $num[0];
			}
			$this->load->view('topic', $data);
		}
		
		
	}
}

?>