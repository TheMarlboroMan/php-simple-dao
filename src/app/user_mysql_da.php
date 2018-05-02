<?php
namespace app;

//TODO: Transactions.
//TODO: Prepared statements.
class user_mysql_da implements \dao\data_accesor {

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

	//TODO: There should actually be an intermediate layer so it honors the neccesary contract.
	public function get($_strategy, array $_params) {

		switch($_strategy) {
		
			case 'get_all': 
				$result=[];
				$query=mysql_query("SELECT * FROM users");
				while($data=mysql_fetch_assoc($query)) {
					$user=new user();
					$result[]=$user->load_from_array($data);
				}
				return $result;
			break;

			//TODO: This is always the same, see???
			case 'find_one_by_id':

				if(!isset($_params['id'])) {
					throw new \Exception("find_one_by_id requires the id parameter");
				}

				$result=null;
				$query=mysql_query("SELECT * FROM users WHERE id='".mysql_real_escape_string($_params['id'])."';");
				if(mysql_num_rows($query)) {
					$result=new user();
					$result->load_from_array(mysql_fetch_assoc($query));
				}
				
				return $result;
			break;

			case 'find_one_by_username':

				if(!isset($_params['username'])) {
					throw new \Exception("find_one_by_username requires the username parameter");
				}

				$result=null;

				$result=null;
				$query=mysql_query("SELECT * FROM users WHERE username='".mysql_real_escape_string($_params['username'])."';");
				if(mysql_num_rows($query)) {
					$result=new user();
					$result->load_from_array(mysql_fetch_assoc($query));
				}

				return $result;
			break;

			default:
				throw new \Exception("Cannot find strategy ".$_strategy." for user_da");
			break;
		}
	}
}
