<?php
require("src/autoload.php");
require("utility.php");

try {

	if($argc!=2) {
		throw new \Exception("program must be used as 'main.php [mock|json|mysql]'");
	}

	$dao=get_dao($argv[1]);

	setup_data($dao);
	update_user($dao);
	delete_user($dao, 3);
	print_hannigan($dao);

	die("ok".PHP_EOL);
}
catch(\Exception $e) {
	die('Something bad went down : '.$e->getMessage().PHP_EOL);
}
