<?php 
	if( !isset( $site_img)){
		require_once("url.php");
		$site_img = "http://".$_SERVER['SERVER_NAME']. dirname( $_SERVER['REQUEST_URI'] )."/".img_path("default_og.png");
	}
	if( !isset( $description )){
		$page_description = "社會局票選系統";
	}
?>

<!DOCTYPE html>
<html>

<head>
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="myassets/css/basic.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php 
		$css_filepath = "myassets/css/".$page.".css";
		if( file_exists($css_filepath ) ){
			echo '<link href="'.$css_filepath.'" rel="stylesheet"> ';
		}
	?>

	<meta charset="utf-8">
	<title><?php echo $page_title; ?></title>
	<meta name="description" content="<?= $page_description ?>"/>

	<meta property="og:image" content="<?= $site_img ?>"/>
	<meta property="og:title" content="<?= $page_title ?>"/>
	<meta property="og:site_name" content="臺中市政府社會局票選系統"/>
	<meta property="og:type" content="article" />
	<meta property="og:url" content="http://<?= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>" />
	<meta property="og:description" content="<?= $page_description ?>" />

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
			<a class="brand" href="index.php">臺中市政府社會局票選系統</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="index.php">近期票選</a></li>
					<?php 
						if( isset( $_SESSION['user'])){
							echo '<li><a href="admin.php">員工專區</a></li>';
							echo '<li><a href="logout.php">登出</a></li>';
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>


