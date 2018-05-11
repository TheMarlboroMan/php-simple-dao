<?php
namespace app;

class user_retriever_mysql extends user_retriever {

	public function get_all() {
		$result=[];
		$query=mysql_query("SELECT * FROM users");
		while($data=mysql_fetch_assoc($query)) {
			$user=new user();
			$result[]=$user->load_from_array($data);
		}
		return $result;
	}

	public function find_one_by_id($_id) {

		return $this->find_by('id', $_id);
	}

	public function find_one_by_username($_username) {

		return $this->find_by('username', $_username);
	}

	private function find_by($_fieldname, $_value) {

		$result=null;
		$query=mysql_query("SELECT * FROM users WHERE ".$_fieldname."='".mysql_real_escape_string($_value)."';");
		if(mysql_num_rows($query)) {
			$result=new user();
			$result->load_from_array(mysql_fetch_assoc($query));
		}
		
		return $result;
	}
}
