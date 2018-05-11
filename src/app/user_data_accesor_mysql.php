<?php
namespace app;

//TODO: Transactions.
//TODO: Prepared statements.
class user_data_accesor_mysql implements \dao\data_accesor {

	private $retriever=null;

	public function insert(\dao\data_object $_do) {

		if($_do->get_id()) {
			throw new \Exception("Unable to insert already persisted user");
		}

		$username=mysql_real_escape_string($_do->get_username());
		$pass=mysql_real_escape_string($_do->get_pass());
		$displayname=mysql_real_escape_string($_do->get_displayname());

		$qstr="INSERT INTO users(username, pass, displayname) VALUES ('".$username."', '".$pass."', '".$displayname."');";
		if(!mysql_query($qstr)) {
			throw new \Exception("Unable to insert user");
		}
		
		$_do->set_id(mysql_insert_id());
	}

	public function update(\dao\data_object $_do) {

		if(!$_do->get_id()) {
			throw new \Exception("Unable to update non-persisted user");
		}

		$username=mysql_real_escape_string($_do->get_username());
		$pass=mysql_real_escape_string($_do->get_pass());
		$displayname=mysql_real_escape_string($_do->get_displayname());

		//TODO: Escape the id, and so on.
		$qstr="UPDATE users SET username='".$username."', pass='".$pass."', displayname='".$displayname."' WHERE id='".$_do->get_id()."';";
		if(!mysql_query($qstr)) {
			throw new \Exception("Unable to update user");
		}
	}

	public function delete(\dao\data_object $_do) {

		if(!$_do->get_id()) {
			throw new \Exception("Unable to delete non-persisted user");
		}

		$qstr="DELETE FROM users WHERE id='".$_do->get_id()."';";
		if(!mysql_query($qstr)) {
			throw new \Exception("Unable to delete user");
		}
	}

	public function retriever() {

		return new user_retriever_mysql();
	}
}
