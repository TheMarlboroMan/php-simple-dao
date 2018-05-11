<?php
namespace app;

class user_data_accesor_mock implements \dao\data_accesor {

	//!The storage is shared accross all instances.
	private static $storage=[];
	private static $cur_id=1;

	private $retriever=null;

	protected function	get_storage() {
		return self::$storage;
	}

	public function __construct() {
		
		$this->retriever=new user_retriever_mock(self::$storage);
	}

	public function insert(\dao\data_object $_do) {

		$existing=$this->retriever->locate_user_key($_do);
		if(false!==$existing) {
			throw new \Exception("Cannot insert already existing user!");
		}

		$_do->set_id(self::$cur_id++); 
		self::$storage[]=clone($_do);
	}

	public function update(\dao\data_object $_do) {

		$key=$this->retriever->locate_user_key($_do);
		if(false===$key) {
			throw new \Exception("Cannot update non persisted user!");
		}

		self::$storage[$key]=clone($_do);
	}

	public function delete(\dao\data_object $_do) {

		$key=$this->retriever->locate_user_key($_do);
		if(false===$key) {
			throw new \Exception("Cannot delete non persisted user!");
		}

		unset(self::$storage[$key]);
	}

	public function retriever() {

		return $this->retriever;
	}
}
