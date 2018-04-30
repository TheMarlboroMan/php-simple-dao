<?php
require("src/autoload.php");

//!Utility function.
function create_user() {
	$shit_data=['username' => 'dirty', 'pass' => '1234encrypted', 'displayname' => 'Dirty Harry'];

	$user=new \app\user();
	$user->load_from_array($shit_data);

	return $user;
}

function setup_data(\dao\dao $_dao) {

	$user=create_user(1);
	$_dao->insert($user);

	$user2=create_user(2);
	$_dao->insert($user2);

	$user2->set_displayname('Dirty Suckah');
	$_dao->update($user2);
}

function update_user(\dao\dao $_dao) {

	$all_users=$_dao->get(\app\user::class, 'get_all');
	$all_users[0]->set_username('hannigan');
	$_dao->update($all_users[0]);
}

try {

	$dao=new \dao\dao();
	$dao->register(\app\user::class, new \app\user_mock_da);
	$dao->register(\app\post::class, new \app\post_mock_da);

	setup_data($dao);
	//$dao->delete($user2);

	update_user($dao);

	$hannigan=$dao->get(\app\user::class, 'find_one_by_username', ['username' => 'hannigan']);
	print_r($hannigan);

	

	die("ok".PHP_EOL);
}
catch(\Exception $e) {
	die('Something bad went down : '.$e->getMessage().PHP_EOL);
}
