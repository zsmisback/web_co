<?php

namespace App\Libraries;

class Hash{

	public static function create($password){
	return password_hash($password, PASSWORD_DEFAULT);
	}
	
	public static function check($password, $hashed_password){
		return (password_verify($password, $hashed_password)) ? true : false;
	}
}

?>