<html>

<head>
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="myassets/css/basic.css" rel="stylesheet">
	<link href="myassets/css/<?php echo $page;?>.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/jquery.fileupload-ui.css">
	<meta charset="utf-8">
	<title><?php echo $page_title; ?></title>
</head>
<body>
<div class="navbar navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
			</button>
			<a class="brand" href="index.php">社會局票選系統</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="index.php">近期票選</a></li>
					<li><a href="admin.php">員工專區</a></li>
					<?php 
						if( isset( $_SESSION['user'])){
							echo '<li><a href="logout.php">登出</a></li>';
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>


