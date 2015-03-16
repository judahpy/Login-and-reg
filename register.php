<?php
require_once 'core/init.php';

if(input::exists()){
	if(Token::check(Input::get('token'))){
	
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'username' => array(
			'required' => true,
			'min' => 2,
			'max' =>20,
		),
		'password' => array(
			'required' => true,
			'min' =>6
		),
		'password_again' => array(
			'required' =>true,
			'matches' => 'password'
		),
		'name' => array(
			'required' =>true,
			'min' => 2,
			'max' =>50
		),
		'email' => array(
			'required' =>true,
			'min'=>5,
			'max' => 60
		),
		'address' => array(
			'required' => true,
			'max' => 55
		),
		'address2' => array(
			'max' =>55
		),
		'postcode' => array(
			'required' => true,
			'max' =>12
		)
		
	));
	if($validation->passed()){
		$user = new User();
		$salt = Hash::salt(32);
		
		//inserting user input into database & formatting salt
		try{
			$user->create(array(
			'username' => Input::get('username'),
			'password' => Hash::make(Input::get('password'), $salt),
			'salt' => $salt,
			'name' => Input::get('name'),
			'email' => Input::get('email'),
			'address' => Input::get('address'),
			'address2' => Input::get('address2'),
			'postcode' => Input::get('postcode'),
			'joined' => date ('Y-m-d H:i:s')
			));
			
			Session::flash('home','You are now registered');
			Redirect::to('index.php');
			
		} catch(Exeption $e){
			die($e->getMessage());
		}
		//show error if input not valid
	}else{
		foreach($validation->errors() as $error){
			echo $error;
			}
		}
	}
}

?>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<div id = "login">
	<h1>Register</h1>
	<p>* This is a required field</p>
	<form action="" method="post">
		<div class="field">
			<label for="username"></label>
			<input type="text" name="username" id= "username" placeholder = "username*" value="<?php echo escape(Input::get('username'));?>" autocomplete="off">
		</div><br>
		<div class = "field">
			<label for="password"></label>
			<input type= "password" name="password" placeholder = "password*" id="password">
		</div><br>
		<div class = "field">
			<label for= "password_again"></label>
			<input type= "password" name="password_again" placeholder = "Enter password again*" id="password_again">
		</div><br>
		<div class = "field">
			<label for= "name"></label>
			<input type= "text" name="name" placeholder = "Full name*" value="<?php echo escape(Input::get('name'));?>">
		</div><br>
		<div class = "field">
			<label for= "email"></label>
			<input type= "text" name="email" placeholder = "Your email*" value="<?php echo escape(Input::get('email'));?>">
		</div><br>
		<div class = "field">
			<label for= "address"></label>
			<input type= "text" name="address" placeholder = "Home address*" value="<?php echo escape(Input::get('address'));?>"><br>
		</div>
		<div class = "field">
			<label for= "address2"></label>
			<input type= "text" name="address2" placeholder = "Address line 2 (optional)" value="<?php echo escape(Input::get('address2'));?>">
		</div><br>
		<div class = "field">
			<label for= "postcode"></label>
			<input type= "text" name="postcode" placeholder = "Postcode*" value="<?php echo escape(Input::get('postcode'));?>">
		</div><br>
		<input type = "hidden" name = "token" value = "<?php echo Token::generate(); ?>">
		<input type = "submit" value="Register">
		<p>Already have an account? <a href = "login.php"> log in here</a></p>
	</form>
</div>
