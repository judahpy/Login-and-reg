<?php
class Config {
	public static function get($path = null){
		if($path){
			$config = $GLOBALS ['config'];
			$path = explode('/',$path);
			
			//check if local host exists within config
			foreach($path as $bit){
			if(isset($config[$bit])){
				$config = $config[$bit];
				}
			}
			return $config;
			}
			
		}
}