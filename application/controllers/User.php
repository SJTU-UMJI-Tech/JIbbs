<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('smtp');
    }
	
	public function register()
	{
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', '用户名', $this->user_model->get_validation_rules('username'));
        $this->form_validation->set_rules('password', '密码', $this->user_model->get_validation_rules('password'));
        $this->form_validation->set_rules('email', '邮箱', $this->user_model->get_validation_rules('email'));
        $this->form_validation->set_rules('captcha', '验证码', $this->user_model->get_validation_rules('captcha'));
        
		if ($this->input->get('url') == NULL)
		{
			$data['redirect_url'] = '';
		}
		else
		{
			$data['redirect_url'] = '?url='.$this->input->get('url');
		}
		
        if ($this->form_validation->run() == FALSE)
        {
            //form failed
            $data['cap_image']=$this->_get_cap_image();
            $data['site_title'] = '注册';
            $this->load->view('user_register', $data);
        }
        else
        {
            //form success
            $data = array
			(
                'username' => strtolower($this->input->post('username')),
                'password' => md5($this->input->post('password')),
                'email' => $this->input->post('email'),
                //'regtime' => time()
            );
            $this->user_model->register($data);
            $this->user_model->login($data);
			$this->site_model->redirect($this->input->get('url'));
        }
	}
	
	/**
    * 获取验证码
    * @return 图片地址的html代码
    */
    private function _get_cap_image()
    {
        $this->load->helper('captcha');
        $vals = array(
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'font_path' => './system/fonts/texb.ttf',
            'img_width' => '100',
            'img_height' => 30,
            'expiration' => 7200
            );

        $cap = create_captcha($vals);
        $this->session->set_userdata('captcha', $cap['word']);
        return $cap['image'];
    }

    /**
     * 检查验证码是否正确 需要输入验证码提交时验证的回调函数
     * @param   $cap 用户输入的验证码
     */
    public function captcha_check($cap)
    {
        if ($cap!=$this->session->userdata('captcha')) {
            $this->form_validation->set_message('captcha_check', '%s 输入不正确.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
    * 刷新验证码
    * @return  图片地址的html代码
    */
    public function refresh_cap_image()
    {
       $cap_image = $this->_get_cap_image();
       echo $cap_image;
    }
	
	/**
     * 用户登录
     */
    public function login()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
		
        $this->form_validation->set_rules('username', '用户名', 'trim|required');
        $this->form_validation->set_rules('password', '密码', 'trim|required|md5');
        $this->form_validation->set_rules('captcha', '验证码', $this->user_model->get_validation_rules('captcha'));
		
		if ($this->input->get('url') == NULL)
		{
			$data['redirect_url'] = '';
		}
		else
		{
			$data['redirect_url'] = '?url='.$this->input->get('url');
		}
		
        if ($this->form_validation->run() == FALSE)
        {
            //form failed
            $data['cap_image'] = $this->_get_cap_image();
            $data['site_title'] = '登录';
			$data['result'] = 'error';
            $this->load->view('user_login', $data);
        }
        else
        {
            //form success
            $login_data = array
			(
                'username' => $this->input->post('username', TRUE),
                'password' => $this->input->post('password')
            );
			
			$result = $this->user_model->login($login_data);
            if ($result == 'success')
			{
				// 验证成功
				$this->site_model->redirect($this->input->get('url'));
            }
			else
			{
				$data['cap_image']=$this->_get_cap_image();
            	$data['site_title'] = '登录';
				$data['result'] = $result;
            	$this->load->view('user_login', $data);
            }
        }
    }
	
	/**
     * 用户登出
     */
    public function logout()
	{
		$this->user_model->logout();
		$this->site_model->redirect($this->input->get('url'));
	}
	
	private function avatar()
	{
		$this->load->helper('form');
		
		$config['upload_path'] = './uploads/temp/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '200';
		$config['max_width'] = '1024';
		$config['max_height'] = '1024';
		$config['overwrite'] = true;
		$config['file_name'] = md5(time());
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		$data['site_title'] = '上传头像';
		if ( ! $this->upload->do_upload('userfile'))
        {
            $data['error'] = $this->upload->display_errors();
        }
        else
        {
			$data['error'] = $this->upload->data();
			
			$config['image_library'] = 'gd2';
			$config['source_image'] = './uploads/temp/'.$data['error']['file_name'];
			$config['new_image'] = './uploads/avatar/'.$this->session->userdata('username').'.jpg';
			$config['width']     = 48;
			$config['height']   = 48;
			
			$this->load->library('image_lib', $config);
			
			$this->image_lib->resize();			
			
			$config['new_image'] = './uploads/avatar/'.$this->session->userdata('username').'-big.jpg';
			$config['width']     = 150;
			$config['height']   = 150;
			
			$this->image_lib->initialize($config);
			$this->image_lib->resize();			
			
			$this->load->helper('file');
			
			unlink($config['source_image']);
			
            $data['error'] = $this->upload->data();
        }
		$this->load->view('user_avatar', $data);
	}
	
	public function settings()
	{
		$data['site_title'] = '设置';
		$data['user_type'] = '0';
		
		
		$this->load->view('user_settings', $data);
	}
	
	
}

?>
