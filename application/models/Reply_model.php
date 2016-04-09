<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reply_model extends CI_Model
{
		
    function __construct()
    {
        parent::__construct();
		$this->load->library('reply_obj');
    }
	
	public function get_reply_arr($data)
	{
		$data['first'] < 0 ? $data['first'] = 0 : 1;
		$data['step'] < 1 ? $data['step'] = 20 : 1;
		$data['order'] != 'desc' ? $data['order'] = 'asc' : 1;

		$this->db->select('*')->from('bbs_reply')
			->order_by($data['order_field'], $data['order'])
			//->limit($data['step'], $data['first'])
			->where(array('floor_id >'=>$data['first'], 'floor_id <='=>$data['first'] + $data['step']))
			->like('content', $data['key']);
			
		if ($data['topic_id'] > 0)
		{
			$this->db->where('topic_id', $data['topic_id']);
		}
		
		$query = $this->db->get();
		
		$index = 0;
		
		$reply_arr = NULL;
		
        foreach ($query->result('Reply_Obj') as $reply)
		{
            $reply_arr[$index++] = $reply;
        }
        return $reply_arr;
	}
	
	public function get_reply_summary($data)
	{
		$this->load->model('user_model');
		$query = $this->db->get_where('bbs_reply', array('topic_id'=>$data['topic_id'], 'floor_id'=>$data['floor_id']));
		if ($query->num_rows() < 1)
		{
			$reply = new Reply_Obj();
			$reply->set_error();
			return $reply;
		}
		$reply = $query->row(0, 'Reply_Obj');
		if ($reply->id != 0)
		{
			$reply->user_name = $this->user_model->get_user_by_id($reply->user_id)->username;
		}
		return $reply;
	}
	
	public function create($data)
	{
    	$this->db->insert('bbs_reply', $data);
		$this->db->update('bbs_topic', array('reply_num'=>$data['floor_id'],'last_reply_id'=>$data['user_id']), 'id='.$data['topic_id']);
		$this->db->set('ovalue', 'ovalue+1', FALSE)->where('oname', 'site_reply_number')->update('bbs_config');
	}
}
