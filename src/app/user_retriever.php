<?php
namespace app;

abstract class user_retriever implements \dao\data_retriever {

	public function check_validity($_classname) {
		return user::class==$_classname;
	}

	abstract public function get_all();
	abstract public function find_one_by_id($_id);
	abstract public function find_one_by_username($_username);
};
