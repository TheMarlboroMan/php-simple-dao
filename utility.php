<?php
function get_dao($_type) {

	$dao=new \dao\dao();

	switch($_type) {
		case 'mock': 
			$dao->register(\app\user::class, new \app\user_data_accesor_mock); 
		break;
		case 'json':
			$dao->register(\app\user::class, new \app\user_data_accesor_json("user.json"));
		break;
		case 'mysql':
			$conn=mysql_connect('localhost', 'root', '1234');
			mysql_select_db('oop');
			$dao->register(\app\user::class, new \app\user_data_accesor_mysql);
			mysql_query("TRUNCATE TABLE users");
		break;
		default:
			throw new \Exception("program must be used as 'main.php [mock|json|mysql]'");
		break;
	}

	return $dao;
}

function create_user() {

	$shit_data=['username' => 'dirty', 'pass' => '1234encrypted', 'displayname' => 'Dirty Harry'];

	$user=new \app\user();
	$user->load_from_array($shit_data);

	return $user;
}

function setup_data(\dao\dao $_dao) {

	for($i=0; $i<3; $i++) {
		$_dao->insert(create_user());
	}
}

//!Updates the first user.
function update_user(\dao\dao $_dao) {

	$all_users=$_dao->retriever(\app\user::class)->get_all();

	if(!count($all_users)) {
		throw new \Exception("There are no users for update_user!");
	}

	$all_users[0]->set_username('hannigan');
	$_dao->update($all_users[0]);
}

//!Deletes user with id $user_id
function delete_user(\dao\dao $_dao, $user_id) {

	$user_with_id=$_dao->retriever(\app\user::class)->find_one_by_id($user_id);
	if(null===$user_with_id) {
		throw new \Exception("There is no user with the id ".$user_id);
	}

	$_dao->delete($user_with_id);
}

function print_hannigan(\dao\dao $_dao) {

	$hannigan=$_dao->retriever(\app\user::class)->find_one_by_username('hannigan');

	if(null===$hannigan) {
		throw new \Exception("There is no hannigan");
	}

	print_r($hannigan);
}
