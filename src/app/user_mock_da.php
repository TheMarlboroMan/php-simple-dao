<?php
namespace app;

class user_mock_da implements \dao\data_accesor {

	//!The storage is shared accross all instances.
	private static $storage=[];
	private static $cur_id=1;

	protected function	get_storage() {
		return self::$storage;
	}

	public function insert(\dao\data_object $_do) {

		$existing=self::locate_user_key($_do);
		if(false!==$existing) {
			throw new \Exception("Cannot insert already existing user!");
		}

		$_do->set_id(self::$cur_id++); 
		self::$storage[]=clone($_do);
	}

	public function update(\dao\data_object $_do) {

		$key=self::locate_user_key($_do);
		if(false===$key) {
			throw new \Exception("Cannot update non persisted user!");
		}

		self::$storage[$key]=clone($_do);
	}

	public function delete(\dao\data_object $_do) {

		$key=self::locate_user_key($_do);
		if(false===$key) {
			throw new \Exception("Cannot delete non persisted user!");
		}

		unset(self::$storage[$key]);
	}

	//TODO: There should actually be an intermediate layer so it honors the neccesary contract.
	public function get($_strategy, array $_params) {

		switch($_strategy) {
			
			case 'get_all': 
				return array_map(function(user $_item) {return clone($_item);}, self::$storage);
			break;

			//TODO: See how these two are the fucking same????. We must do something about that!
			case 'find_one_by_id':
				if(!isset($_params['id'])) {
					throw new \Exception("find_one_by_id requires the id parameter");
				}

				$key=self::locate_user_key_generic(function(user $_item) use ($_params) {return $_item->get_id()==$_params['id'];});
				if(false!==$key) {
					return self::$storage[$key];
				}
				else {
					return null;
				}

			break;

			case 'find_one_by_username':
				if(!isset($_params['username'])) {
					throw new \Exception("find_one_by_username requires the username parameter");
				}

				$key=self::locate_user_key_generic(function(user $_item) use ($_params) {return $_item->get_username()==$_params['username'];});
				if(false!==$key) {
					return self::$storage[$key];
				}
				else {
					return null;
				}
			break;

			default:
				throw new \Exception("Cannot find strategy ".$_strategy." for user_da");
			break;
		}
	}

	private static function locate_user_key(user $_user) {

		return self::locate_user_key_generic(function(user $_item) use ($_user) {
			return $_user->get_id()==$_item->get_id();
		});

		return count($filtered) ? key($filtered) : false;
	}

	//! This returns the first key that was found...
	private static function locate_user_key_generic($_function) {

		$filtered=array_filter(self::$storage, $_function);
		return count($filtered) ? key($filtered) : false;
	}

}
