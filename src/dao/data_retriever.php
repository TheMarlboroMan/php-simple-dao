<?php
namespace dao;

interface data_retriever {

	//Will have to check if the classname passed corresponds to the class it is supposed to manage.
	public function check_validity($_classname);
};
