<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reply_obj
{
	public $id;
	public $topic_id;
	public $user_id;
	public $floor_id;
	public $content;
	public $CREATE_TIMESTAMP;
	public $UPDATE_TIMESTAMP;
	public $state;
	
	public function __construct()
	{
		 
	}
	
	public function set_error()
	{
		$this->id = 0;
		$this->topic_id = 0;
		$this->user_id = 0;
		$this->floor_id = 0;
		$this->content = 'error_topic';
		$this->state = 0;
	}
}
