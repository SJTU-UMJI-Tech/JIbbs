<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_obj
{
	public $id;
	public $name_ch;
	public $name_en;
	public $name;
	public $topic_num;
	
	public function __construct()
	{
		$this->name = $this->name_ch;
	}
	
	public function set_error()
	{
		$this->id = 0;
		$this->name_ch = 'error_module';
		$this->name_en = 'error_module';
		$this->topic_num = 0;
	}
}
