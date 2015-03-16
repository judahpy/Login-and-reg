<?php 
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
	Redirect::to('index.php');
}

if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'cpassword' =>array(
				'required' => true,
				'min' => 6
			),
			'npassword' => array(
				'requied' => true,
				'min' => 6		
			),
			'napassword' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'npassword'	
				)				
			));
			//salt the new password if password matched
			if($validation->passed()){
				if(Hash::make(Input::get('cpassword'), $user->data()->salt) !== $user->data()->password){
					echo 'The password entered does not match actual password';
				}else{
				
				//length of salt and update new password
				
					$salt = Hash::salt(32);
					$user->update(array(
						'password' =>Hash:: make(Input::get('npassword'), $salt),
						'salt' => $salt

					));
					//redirect user to homepage and give feedback of new password
					Session::flash('home', 'Your password has been changed.');
					Redirect::to('index.php');
				}
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
<ul>
		<li>
			<a href = "index.php">Home</a>
		</li>
	  <li>
		Settings
		<ul>
			
			<li>
				<a href ="update.php">View details</a>
			</li>
			<li>
				<a href ="changepass.php">Change password</a>
			</li>
		</ul>
			<li>
				<a href ="logout.php">Log out</a>
			</li>
	  </li>
	</ul>	
</div>
<div id = "login">
<h1>Change password</h1>
	<form action ="" method="post">
		<div class = "field">
			<label for ="cpassword"></label>
			<input type = "password" placeholder ="Current password" name = "cpassword" id = "cpassword">
		</div><br>
		<div class = "field">
			<label for ="npassword"></label>
			<input type = "password" placeholder ="Enter a new password" name = "npassword" id = "npassword">
		</div><br>
		<div class = "field">
			<input type = "password" placeholder = "Repeat new password" name = "napassword" id = "napassword">
		</div><br>
			<input type = "submit" value = "Change">
			<input type = "hidden" name ="token" value = "<?php echo Token::generate(); ?>">
	</form>
</div>