<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topic_obj
{
	public $id;
	public $module_id;
	public $user_id;
	public $name;
	public $reply_num;
	public $last_reply_id;
	public $CREATE_TIMESTAMP;
	public $UPDATE_TIMESTAMP;
	
	public function __construct()
	{
		 
	}
	
	public function set_error()
	{
		$this->id = 0;
		$this->module_id = 0;
		$this->user_id = 0;
		$this->name = 'error topic';
		$this->reply_num = 0;
		$this->last_reply_id = 0;
	}

}
