<?php

namespace dao;

class dao {

	//!Key -> value map, where key is the class name and value is the data_accesor object.
	private $mapper=[];

	//!Will register a retriever for the class... It actually should be more than a retriever, but a data_accesor...
	public function register($_class, data_accesor $_da) {

		if($this->check_registered($_class)) {
			throw new \Exception($_class.' was already registered with dao');
		}

		$this->mapper[$_class]=$_da;
	}

	public function insert(data_object $_do) {

		$da=$this->get_data_accesor_for(get_class($_do));
		$da->insert($_do);
	}

	public function update(data_object $_do) {

		$da=$this->get_data_accesor_for(get_class($_do));
		$da->update($_do);
	}

	public function delete(data_object $_do) {

		$da=$this->get_data_accesor_for(get_class($_do));
		$da->delete($_do);
	}

	public function get($_type, $_strategy, array $_params=[]) {

		$da=$this->get_data_accesor_for($_type);
		return $da->get($_strategy, $_params);
	}

	private function check_registered($_class) {

		return array_key_exists($_class, $this->mapper);
	}

	private function get_data_accesor_for($classname) {

		if(!$this->check_registered($classname)) {
			throw new \Exception("No data_accesor was registered in dao for ".$classname);
		}

		return $this->mapper[$classname];
	}
};
