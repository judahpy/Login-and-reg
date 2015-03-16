<?php 
class Hash{
	public static function make($string, $salt = ''){
		return hash('sha256', $string . $salt);
	}
	//provide a secure salt
	public static function salt($length){
		return mcrypt_create_iv($length);
	}
	// unique hash
	public static function unique(){
		return self::make(uniqid());
	}
}