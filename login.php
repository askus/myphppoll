<?php 
require_once( 'utility.php');

$page_title ="登入";
$page = "login";

session_start();

//echo sprintf("%s, %s", $_POST['name'], $_POST['password'] );

if( isset( $_POST['name'])  && isset( $_POST['password']) ){ 
	require_once('models.php');
	$name = trim( $_POST['name'] );
	$password = trim( $_POST['password']) ;
	$userDao = new UserDAO();
	$user = $userDao->getUserByName( $name );
	if( !is_null( $user) && $user->getName() == $name && $user->getPassword() == md5( $password ) ){
		//login Success
		$_SESSION['user'] = $user ; 
		//session_register("username");
	
	}else{
		$err_msg = "<div class='alert'>使用者帳號或者密碼錯誤，請查明後重新登入</div>" ; 
	}
}
if ( isset($_SESSION['user']) ){
	redirect_to('admin.php');
}		
?>

<?php require( "menu.php"); ?>


<div class="container">
	<div class="row">
	
		<?php if( isset( $err_msg) ){ echo $err_msg; } ?> 
	</div>
	
	<div class="row">
		<div class="span2"></div>
		<div class="span8">
			<form action="login.php" method="POST" class="form">
				<p><label>帳號：</label><input type="text" name="name"></input></p>
				<p><label>密碼：</label><input type="password" name="password"></input></p>
				<input type="submit" class="btn btn-medium btn-primary"></input>
			</div>	
		</div>
		<div class="span2"></div>
	</div>
</div>

<?php require("bottom.php"); ?>