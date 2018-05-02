<?php
namespace app;

//!Extends the user_mock_da to write the storage to a json file with each change.
class user_json_da extends user_mock_da implements \dao\data_accesor {

	private $filename=null;

	public function __construct($_filename) {

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
