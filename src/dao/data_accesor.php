<?php
namespace dao;

interface data_accesor {

//TODO: This needs more work...
	public function insert(data_object $_do);
	public function update(data_object $_do);
	public function delete(data_object $_do);
	public function get($_strategy, array $_params);
}

