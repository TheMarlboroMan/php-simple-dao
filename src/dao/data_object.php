<?php
namespace dao;

interface data_object {

	//!must load own fields from the array, where key is the property name and value its value.
	public function	load_from_array(array $array);

	//!must return an array where key is the property/get/set and value the fieldname in the persistence layer
	public function	get_property_map();
};
