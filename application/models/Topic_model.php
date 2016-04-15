<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topic_model extends CI_Model
{
		
    function __construct()
    {
        parent::__construct();
		$this->load->library('topic_obj');
    }
	
	public function get_topic_arr($data)
	{
		$data['first'] < 0 ? $data['first'] = 0 : 1;
		$data['step'] < 1 ? $data['step'] = 10 : 1;
		$data['order'] != 'desc' ? $data['order'] = 'asc' : 1;

		$this->db->select('*')->from('bbs_topic')
			->order_by($data['order_field'], $data['order'])
			->limit($data['step'], $data['first'])
			->like('name', $data['key']);
			
		if ($data['module_id'] > 0)
		{
			$this->db->where('module_id', $data['module_id']);
		}
		
		$query = $this->db->get();
		
		$index = 0;
		
		$topic_arr = NULL;
		
        foreach ($query->result('Topic_Obj') as $topic)
		{
            $topic_arr[$index++] = $topic;
        }
        return $topic_arr;
	}
	
	public function get_topic_by_id($id)
	{
		$query = $this->db->select('*')->from('bbs_topic')->where('id', $id)->get();
		if ($query->num_rows() == 1)
		{
			return $query->row(0, 'Topic_Obj');
		}
		$topic = new Topic_Obj();
		$topic->set_error();
		return $topic;
	}
	
	public function create($data)
	{
		$this->load->model('reply_model');
    	$this->db->insert('bbs_topic', array
		(
			'module_id'     => $data['module_id'],
			'user_id'       => $data['user_id'],
			'name'          => preg_replace("/<([a-zA-Z]+)[^>]*>/","<\\1>",$data['topic']),
			'reply_num'     => 1,
			'last_reply_id' => $data['user_id']
		));
		$query = $this->db->select('id')->from('bbs_topic')->where('name', $data['topic'])->order_by('CREATE_TIMESTAMP', 'desc')->limit(1, 0)->get();
		$topic_id = $query->row(0)->id;
		if ($topic_id <= 0)
		{
			return 0;
		}
		$this->db->set('topic_num', 'topic_num+1', FALSE)->where('id', $data['module_id'])->update('bbs_module');
		$this->db->set('ovalue', 'ovalue+1', FALSE)->where('oname', 'site_topic_number')->update('bbs_config');
		//$this->db->update('bbs_module', array('topic_num'=>'topic_num+1'), 'id='.$data['module_id']);
		
		$this->reply_model->create(array
		(
			'topic_id'      => $topic_id,
			'user_id'       => $data['user_id'],
			'floor_id'      => 1,
			'content'       => $data['content']
		));
		return $topic_id;
	}
}
