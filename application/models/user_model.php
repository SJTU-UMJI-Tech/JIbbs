<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model
{
	
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * �û�ע��
     * @param  $data  ע����Ϣ
     */
    public function register($data)
    {
    	return $this->db->insert('bbs_user', $data);
    }
    

}    
?>