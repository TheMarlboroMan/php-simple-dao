<?php
namespace app;

class post implements \dao\data_object {
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
