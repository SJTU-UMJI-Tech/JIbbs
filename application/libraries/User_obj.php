<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_obj
{
	public $id;
	public $username;
	public $password;
	public $email;
	public $avatar;
	
	public function __construct()
	{
		
	}
	
	public function set_error()
	{
		$this->id = 0;
		$this->username = 'error_user';
		$this->password = '';
		$this->email = '';
		$this->avator= 'default.png';
	}
}
