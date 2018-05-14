<?php
namespace app;

//!Extends the user_mock_da to write the storage to a json file with each change.
//TODO: This is actually wrong: the user_data_accesor_json IS NOT a user_data_accesor_mock
//and the abstraction breaks in many places: for example, access to the storage is needed
//in the parent class and both a json and mock accessors would share the same storage.
//What should actually happen here is that this is implemented in terms of the mock, and
//so could have a mock object. That would not fix the sharing and providing of the container,
//so maybe both of them should actually be implemented in terms of a third class: the 
//container.
class user_data_accesor_json extends user_data_accesor_mock implements \dao\data_accesor {

	private $filename=null;

	public function __construct($_filename) {

		parent::__construct();
		$this->filename=$_filename;
	}

	public function insert(\dao\data_object $_do) {
		
		parent::insert($_do);
		$this->update_json_file();
	}

	public function update(\dao\data_object $_do) {

		parent::update($_do);
		$this->update_json_file();
	}

	public function delete(\dao\data_object $_do) {

		parent::delete($_do);
		$this->update_json_file();
	}

	private function update_json_file() {

		$file=fopen($this->filename, "w");
		if(!$file) {
			throw new \Exception("Unable to open user_json_da file ".$this->filename);
		}

		$raw_data=[];
		$raw_data['users']=array_map(function(\dao\data_object $_item) {return self::data_object_to_array($_item);}, $this->get_storage());

		fwrite($file, json_encode($raw_data));
		fclose($file);
	}

	private static function data_object_to_array(\dao\data_object $_do) {
		$map=$_do->get_property_map();
		$result=[];

		foreach($map as $key => $value) {
			$method_name='get_'.$value;
			if(method_exists($_do , $method_name)) {
				$result[$value]=$_do->$method_name();
			}
		}

		return $result;
	}
}
