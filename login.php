<?php 
require_once 'core/init.php';
if(Input::exists()){
	if(Token::check(Input::get('token'))){
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'username' => array('required' =>true),
		'password' => array('required' =>true)
	));
	if ($validation->passed()){
		$user = new User();
		$login = $user->login(Input::get('username'), Input::get('password'));
		
		if($login){
			Redirect::to('index.php');
		}else{
			echo 'failed to log in';
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

<body>
	
<div id = "login">
	<h1>Login</h1>
		<br>
		
		<form action = "" method = "post">
			<div class = "field">
				<label for= "username"></label>
				<input type= "text" placeholder ="username" name = "username" id ="username" autocomplete="off"><br>
			</div>
			<div class = "field">
				<label for= "password"></label>
				<input type= "password" placeholder ="password" name = "password" id ="password" autocomplete="off"><br>
			</div>
			<input type = "hidden" name="token" value = "<?php echo Token::generate(); ?>">
			<input type = "submit" value="Log in">
		</form>
	<p>Don't have an account? <a href = "register.php"> register here</a></p>
	<p>Report <a href = "WP_assignment1.docx"> Download Report</a></p>
</div>
</body>