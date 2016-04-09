<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	
	private $validation_rules;
	
    function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('user_obj');
		$this->validation_rules = array
		(
			'username' => 'trim|required|alpha_dash|min_length[3]|max_length[12]|is_unique[bbs_user.username]',
			'password' => 'trim|required|min_length[6]|max_length[20]',
			'email'    => 'trim|required|valid_email|is_unique[bbs_user.email]',
			'captcha'  => 'trim|callback_captcha_check'
		);
    }
	
    /**
     * 用户注册
     * @param  $data  注册信息
     */
    public function register($data)
    {
    	$this->db->insert('bbs_user', $data);
		// 更新网站统计信息 注册用户
        $this->db->set('ovalue', 'ovalue+1', FALSE)->where('oname', 'site_user_number')->update('bbs_config');
    }
    
	public function login($data)
    {
		$flag_find = false;
		if(!$flag_find)
		{
			// 尝试查找用户名
			$this->db->where('username', $data['username']);
			$query = $this->db->get('bbs_user');
			if ($query->num_rows() > 0)
			{
				$user = $query->row_array();
				$flag_find = true;
			}
		}
		if(!$flag_find)
		{
			// 尝试查找邮箱
			$this->db->where('email', $data['username']);
        	$query = $this->db->get('bbs_user');
			if ($query->num_rows() > 0)
			{
				$user = $query->row_array();
				$flag_find = true;
			}
		}
		if(!$flag_find)
		{
			return 'error_username';
		}
		// 验证密码
		if ($user['password'] == $data['password'])
		{
            $this->session->set_userdata('username', $user['username']);
			$this->session->set_userdata('uid', $user['id']);
			//$this->session->set_userdata('group_id', $user['group_id']);
			//$this->session->set_userdata('notification', $user['notice']);
			//$this->session->set_userdata('is_active', $user['is_active']);
			$this->session->set_userdata('avatar', $user['avatar']);
			//$this->session->set_userdata('node_follow', $user['node_follow']);
			//$this->session->set_userdata('user_follow', $user['user_follow']);
			//$this->session->set_userdata('topic_follow', $user['topic_follow']);
            return 'success';
        }
		else
		{
        	return 'error_password';
        }
    }
	
	public function logout()
	{
		$this->session->set_userdata('username', '');
		$this->session->set_userdata('uid', '');
		$this->session->set_userdata('avatar', '');
	}
	
	public function get_validation_rules($data)
	{
		return $this->validation_rules[$data];
	}
	
	public function get_user_by_id($id)
	{
		$query = $this->db->select('*')->from('bbs_user')->where('id', $id)->get();
		if ($query->num_rows() == 1)
		{
			return $query->row(0, 'User_Obj');
		}
		$user = new User_Obj();
		$user->set_error();
		return $user;
	}
	
	public function update_avatar($id)
	{
		$this->db->update('bbs_user', array('avatar'=>'1'), 'id='.$id);
	}
}    
?>
