<?php 
class Validate{
	private $_passed = false,
			$_errors = array(),
			$_db = null;
	
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	
	public function check($source, $items = array()){
		foreach($items as $item =>$rules){
			foreach($rules as $rule => $rule_value){
			
				$value = trim($source[$item]);
				$item = escape($item); //sanitize
				
				//validating user input. Ensuring it matches with database requirements
				if($rule === 'required' && empty($value)){
					$this->addError("{$item} is required. <br>");
				}else if(!empty($value)){
					switch($rule){
						//DB minimum is 2 chars
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be a minimum of {$rule_value} characters.<br>");
							}
						break;
						//set max rules
						case 'max':
						if(strlen($value) > $rule_value){
								$this->addError("{$item} cannot exceed a maximum of {$rule_value} characters.<br>");
							}
						
						break;
						//validating the user password
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("Make sure you entered the new password correctly, both times.");
							}
						break;						
					}
				}
				
			}
		}
		//check if empty
		if(empty($this->_errors)){
			$this->_passed = true;
		}
		
		return $this;
	}	
	
	private function addError($error){
		$this->_errors[] = $error;
	}
	
	public function errors(){
		return $this->_errors;
	}
	
	public function passed(){
		return $this->_passed;
	}
}
				