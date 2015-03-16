<?php 
require_once 'core/init.php';

if(Session::exists('home')){
	echo Session::flash('home');
}
$user = new User();
if($user->isLoggedIn()){

?>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>		
	<ul>
		<li>
			<a href = "">Home</a>
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
	<h1> Hello <?php echo escape($user->data()->username); ?>!</h1>
<?php 
}else{
	Redirect::to('login.php');
}
?>
