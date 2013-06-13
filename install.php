<?php
	require_once( "config.php" ) ;
	require_once("models.php");


	// create table 
	$db = new DB();

	$db->query('DROP table options');
	$db->query('DROP table polls');
	$db->query('DROP table users');
	$db->query('DROP table votes');

	// create user table 
	$schema = array(
		array("user_id", "INT UNSIGNED AUTO_INCREMENT NOT NULL"),
		array("department", "CHAR(255) NOT NULL"),
		array("name", "CHAR(255) NOT NULL UNIQUE"),
		array("password", "CHAR(255) NOT NULL") ,
	);
	create_table( $db, "users", $schema, "user_id");

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

	$db->close();

	//insert root id 
	$user= new User();
	$user->setName( $_db['dbuser'] );
	$user->setPassword( md5( $_db['dbpass']) );
	$user->setDepartment( "綜合企劃科");
	$userDao = new UserDAO();
	$root_user_id = $userDao->insertUser( $user );
	$userDao->close();

	$message= "Establish tables successly!" ;
	echo $message;




	// insert testing data 
	$poll = new Poll();
	$poll->setTitle("婦少科LOGO票選活動");
	$poll->setDepartment("婦女及兒童福利科");
	$poll->setStartDate( new DateTime( null, new DateTimeZone('Asia/Taipei')) );
	$due_date =  new DateTime( null, new DateTimeZone('Asia/Taipei') );
	$due_date->modify('+1 day'); 
	$poll->setDueDate( $due_date  );
	$poll->setUserId( $root_user_id );
	$poll->setImgFilename( "logo_3.jpg"); 
	$poll->setDescription("票選最優質的婦少科LOGO");

	$option1 = new Option();
	$option1->setImgFilename( "option.png");
	$option1->setDescription("選項一");
	$option1->setRank( 0);

	$option2 = new Option();
	$option2->setImgFilename( "option.png");
	$option2->setDescription("選項二");
	$option2->setRank( 1);

	$option3 = new Option();
	$option3->setImgFilename( "option.png");
	$option3->setDescription("選項三");
	$option3->setRank( 2);

	$poll->setOptions( array( $option1, $option2, $option3)); 
	$pollDao = new PollDAO();
	$pollDao->insertPoll( $poll );


	$poll = new Poll();
	$poll->setTitle("救助科LOGO票選活動");
	$poll->setDepartment("社會救助科");
	$poll->setStartDate( new DateTime( null, new DateTimeZone('Asia/Taipei')) );
	$due_date =  new DateTime( null, new DateTimeZone('Asia/Taipei') );
	$due_date->modify('+1 day'); 
	$poll->setDueDate( $due_date  );
	$poll->setUserId( $root_user_id );
	$poll->setImgFilename( "logo_1.jpg"); 
	$poll->setDescription("票選最優質的救助科LOGO");

	$option1 = new Option();
	$option1->setImgFilename( "option.png");
	$option1->setDescription("選項一");
	$option1->setRank( 0);

	$option2 = new Option();
	$option2->setImgFilename( "option.png");
	$option2->setDescription("選項二");
	$option2->setRank( 1);

	$option3 = new Option();
	$option3->setImgFilename( "option.png");
	$option3->setDescription("選項三");
	$option3->setRank( 2);

	$poll->setOptions( array( $option1, $option2, $option3)); 
	$pollDao = new PollDAO();
	$pollDao->insertPoll( $poll );


	$pollDao->close();

?>

