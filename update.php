<?php
require_once 'core/init.php';

$user = new User();
if(!$user->isLoggedIn()){
	Redirect::to('index.php');	
}
//check if token matches
if (Input::exists()){
	if(Token::check(Input::get('token'))){
		//validate name of user
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
		'name'=>array(
			'required' =>true,
			'min' =>2,
			'max' =>50
			),
		'email' => array(
			'required' =>true,
			'min'=>5,
			'max' => 60
		),
		'address'=>array(
			'required' =>true,
			'max' =>55
			),		
		'address2'=>array(
			'required' =>true,
			'max' =>55
			),	
		'postcode'=>array(
			'required' =>true,
			'max' =>55
			)					
		));
		
		if ($validation->passed()){
			try{
				$user->update(array(
					'name' => Input::get('name'),
					'email' => Input::get('email'),
					'address' => Input::get('address'),
					'address2' => Input::get('address2'),
					'postcode' => Input::get('postcode')
				));
				
				Session::flash('home', 'Your details are now up to date.');
				Redirect::to('index.php');
				
			}catch(Exception $e){
				die($e->getMessage());
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
	<h1>My details</h1>
	<p>Here is a list of your details you told us when you registered.</p>
	<p>If anything has changed, you may update here.</p>
	<form action ="" method="post">
		<div id = "field">
			<label for ="name">Name</label>
			<input type = "text" name = "name" value="<?php echo escape($user->data()->name);?>">
		</div><br>
		<div id = "field">
			<label for= "email">Email</label>
			<input type= "text" name="email" value="<?php echo escape($user->data()->email);?>">
		</div><br>
		<div id = "field">
			<label for ="address">Address</label>
			<input type = "text" name = "address" value="<?php echo escape($user->data()->address);?>">
		</div><br>
		<div id = "field">
			<label for ="address2"></label>
			<input type = "text" name = "address2" value="<?php echo escape($user->data()->address2);?>">
		</div><br>
		<div id = "field">
			<label for ="postcode">Postcode</label>
			<input type = "text" name = "postcode" value="<?php echo escape($user->data()->postcode);?>">
		</div><br>
			<input type = "submit" value = "Update">
			<input type = "hidden" name ="token" value = "<?php echo Token::generate(); ?>">
	</form>
</div>