<?php
	require_once( "config.php" ) ;
	require_once("models.php");

	$db = new DB();
	//$db->connect_db( $_db['dbhost'], $_db['dbuser'] ,$_db['dbpass'], $_db['dbname']) ;

	# check if table exist 

	// create poll table 
	$schema = array( 
		array("poll_id", "INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY" ), 
		array("title", "CHAR(255)"), 
		array("description", "text"),
		array("department", "CHAR(255)"),
		array("start_date", "DATETIME"),
		array("due_date", "DATETIME"), 
		array("img_filename", "CHAR(255)"),
		array("user_id", "integer UNSIGNED NOT NULL")	
	);
	create_table( $db, "polls", $schema, NULL); 

	// create option table
	$schema = array( 
		array("option_id", "INT UNSIGNED AUTO_INCREMENT NOT NULL"), 
		array("img_filename", "CHAR(255)"), 
		array("description", "TEXT"), 
		array("rank", "INT "),
		array("poll_id", "INT UNSIGNED"), 
	);
	create_table( $db, "options", $schema, "option_id"); 

	//create vote table 
	$schema = array( 
		array("vote_id", "INT UNSIGNED AUTO_INCREMENT NOT NULL"),
		array("option_id", "INT UNSIGNED NOT NULL"),
		array("ip","CHAR(128)"),
		array("last_vote", "TIMESTAMP"),
	);
	create_table( $db, "votes", $schema, "vote_id");

	// create user table 
	$schema = array(
		array("user_id", "INT UNSIGNED AUTO_INCREMENT NOT NULL"),
		array("department", "CHAR(255) NOT NULL"),
		array("name", "CHAR(255) NOT NULL UNIQUE"),
		array("password", "CHAR(255) NOT NULL") ,
	);
	create_table( $db, "users", $schema, "user_id");


	$db->close();
	//insert root id 
	$user= new User();
	$user->setName( $_db['dbuser'] );
	$user->setPassword( md5( $_db['dbpass']) );
	$user->setDepartment( "綜合企劃科");
	$userDao = new UserDAO();
	//$userDao->connect_db( $_db['dbhost'], $_db['dbuser'] ,$_db['dbpass'], $_db['dbname']) ;
	$userDao->insertUser( $user );

	$message= "Establish tables successly!" ;
	echo $message;
?>
