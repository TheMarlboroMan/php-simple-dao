<?php
namespace app;

interface user_retriever {
	public function by_id($_id);
	public function by_displayname($_dn);
};

interface post_retriever {
	public function by_id($_id);
	public function by_user(user);
};


