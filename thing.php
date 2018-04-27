<?php
interface data_object {
	//!must load own fields from the array, where key is the property name and value its value.
	public function	load_from_array(array $array);

	//!must return an array where key is the property/get/set and value the fieldname in the persistence layer
	public function	get_property_map();
};

class user implements data_object {
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

	public function load_from_array(array $_d) {
		foreach($this->get_property_map() as $k => $v) {
			if(isset($_d[$k])) {
				$this->$k=$v;
			}
		}
	}

	public function get_property_map() {

		return ['id' => 'id',
			'username' => 'username',
			'pass' => 'pass',
			'displayname' => 'displayname'];
	}
};

class post implements data_object {
	private $id;
	private $user_id;
	private $title;
	private $text;

	public function	get_id()		{return $this->id;}
	public function get_user_id()		{return $this->user_id;}
	public function	get_title() 		{return $this->title;}
	public function	get_text()		{return $this->text;}

	public function set_id($_v)		{$this->id=$_v; return $this;}
	public function set_user_id($_v)	{$this->user_id=$_v; return $this;}
	public function set_title($_v)		{$this->title=$_v; return $this;}
	public function set_text($_v)		{$this->text=$_v; return $this;}

	public function load_from_array(array $_d) {
		foreach($this->get_property_map() as $k => $v) {
			if(isset($_d[$k])) {
				$this->$k=$v;
			}
		}
	}

	public function get_property_map() {
		return ['id' => 'id',
			'user_id' => 'user_id',
			'title' => 'title',
			'text' => 'text'];
	}
};

//TODO: Here is the gist... we actually need a "persistence" interface.

interface retriever {

}

interface user_retriever {
	public function by_id($_id);
	public function by_displayname($_dn);
};

interface post_retriever {
	public function by_id($_id);
	public function by_user(user);
};

class dao {

	private $mapper=[];

	public function register($_class, retriever $_retriever) {

	}

	public function insert(data_object $_do) {

	}

	public function update(data_object $_do) {

	}

	public function delete(data_object $_do) {

	}

	public function get($_type, $_strategy, array $_params) {

	}

	private function check($_class) {
		//TODO: Check if registered.
	}
};
