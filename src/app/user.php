<?php

namespace app;
class user implements \dao\data_object {
	private $id;
	private $username;
	private $pass;
	private $displayname;

	public function get_id() 		{return $this->id;}
	public function get_username() 		{return $this->username;}
	public function get_pass() 		{return $this->pass;}
	public function get_displayname() 	{return $this->displayname;}

	public function set_id($_v) 		{$this->id=$_v; return $this;}
	public function set_username($_v) 	{$this->username=$_v; return $this;}
	public function set_pass($_v) 		{$this->pass=$_v; return $this;}
	public function set_displayname($_v) 	{$this->displayname=$_v; return $this;}

	//
	public function load_from_array(array $_d) {
		foreach($this->get_property_map() as $k => $discard) {

			if(isset($_d[$k])) {
				$this->$k=$_d[$k];
			}
		}

		return $this;
	}

	public function get_property_map() {

		return ['id' => 'id',
			'username' => 'username',
			'pass' => 'pass',
			'displayname' => 'displayname'];
	}
};
