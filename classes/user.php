<?php 
class User{
	private $_db,
			$_data,
			$_sessionName,
			$_isLoggedIn;
	
	public function __construct($user= null){
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
					if($this->find($user)){
						$this->_isLoggedIn = true;
					}else{
						//loggout
				}
			}
		}else{
			$this->find($user);
		}
	}
	//update function 
	public function update($fields = array(), $id= null){
				
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		
		if(!$this->_db->update('users', $id, $fields)){
			throw new Exception('Could not update');
		}
	}
	
	public function create($fields = array()){
		if(!$this->_db->insert('users', $fields)){
			throw new Exception('Oops, something went wrong while trying to create you account.');
		}
	}
	//check if user exists
	public function find($user = null){
		if($user){
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('users', array($field, '=', $user));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function login($username = null, $password= null){
		$user = $this->find($username);
		if($user){
		//check password
			if($this->data()->password === Hash::make($password, $this->data()->salt)){
				Session::put($this->_sessionName, $this->data()->id);
				return true;
			}
		}
		return false;
	}
	//logout function
	public function logout(){
		Session::delete($this->_sessionName);
	}
	//data pass
	public function data(){
		return $this->_data;
	}
	//log in session
	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}
}