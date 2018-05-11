<?php
namespace app;

class user_retriever_mock extends user_retriever {

	private $storage=null;

	public function __construct(&$_storage) {

		$this->storage=&$_storage;
	}

	public function get_all() {

		return array_map(function(user $_item) {return clone($_item);}, $this->storage);
	}

	public function find_one_by_id($_id) {

		$key=$this->locate_user_key_generic(function(user $_item) use ($_id) {return $_item->get_id()==$_id;});
		if(false!==$key) {
			return $this->storage[$key];
		}
		else {
			return null;
		}
	}

	public function find_one_by_username($_username) {

		$key=$this->locate_user_key_generic(function(user $_item) use ($_username) {return $_item->get_username()==$_username;});
		if(false!==$key) {
			return $this->storage[$key];
		}
		else {
			return null;
		}
	}

	public function locate_user_key(user $_user) {

		return $this->locate_user_key_generic(function(user $_item) use ($_user) {
			return $_user->get_id()==$_item->get_id();
		});

		return count($filtered) ? key($filtered) : false;
	}

	//! This returns the first key that was found...
	public function locate_user_key_generic($_function) {

		$filtered=array_filter($this->storage, $_function);
		return count($filtered) ? key($filtered) : false;
	}

}
