<?php
	error_reporting(E_ALL);
	include ('login.php');	
	$pfad = './content/';
	$pages['nw'] = $pfad . 'news.php';
	$pages['ga'] = $pfad . 'galery.php';
	$pages['gasin'] = $pfad . 'g_single.php';
	$pages['gaov'] = $pfad . 'g_overview.php';
	$pages['pr'] = $pfad . 'projects.php';
	$pages['prsin'] = $pfad . 'p_single.php';
	$pages['prov'] = $pfad . 'p_overview.php';	
	$pages['sc'] = $pfad . 'scripts.php';
	$pages['scsin'] = $pfad . 's_single.php';
	$pages['av'] = $pfad . 'audiovideo.php';
	$pages['avsin'] = $pfad . 'a_single.php';
	$pages['am'] = $pfad . 'aboutme.php';
	$pages['404'] = $pfad . '404.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>kissingmuse</title>
	
    <meta name="author" content="Jens Dreyer" />
    <meta name="description" content="Portfolio" />
    <meta name="keywords" content="design, artwork, conceptart, portfolio" />
    <meta name="robots" content="all" />
    <meta name="revisit-after" content="14 days" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="content-language" content="de" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/upl.css" type="text/css" />
	<link rel="stylesheet" href="css/nav.css" type="text/css" />
	<link rel="stylesheet" href="css/new.css" type="text/css" />
	<link rel="stylesheet" href="css/gal.css" type="text/css" />
	<link rel="stylesheet" href="css/pro.css" type="text/css" />
	<link rel="stylesheet" href="css/avscr.css" type="text/css" />
	<link rel="stylesheet" href="css/abme.css" type="text/css" />		
	<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
	<link type="text/css" href="css/smoothness/jquery-ui-1.8.14.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.14.custom.min.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src="fancybox/jquery.easing-1.3.pack.js"></script>
	<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.js"></script>
	<script type="text/javascript" src="fancybox/fancybox_options.js"></script>
	<script type="text/javascript" src="js/everscripts.js"></script>
	<script type="text/javascript" src="js/lyricscripts.js"></script>
	<script type="text/javascript" src="js/galeryscripts.js"></script>
</head>
<body>
	<div id="redtopline"></div>
	<div id="topspace"></div>
<?php
	include ('nav.php');
	echo'
	<div id="middle">
		<div id="white">
			<div id="content">';
   	include ('upload.php');			

	if(isset($_GET['page']) && isset($pages[$_GET['page']]) && file_exists($pages[$_GET['page']])){	
		include($pages[$_GET['page']]);	}
	elseif(!isset($_GET['page'])){
		include($pages['nw']);			}
	else{
		include($pages['404']);			}
	echo'
			</div>
		</div>
	</div>
	<div id="red"></div>
	<div id="root">
		<div id="credit">© 2011 Jens Dreyer</div>';
   
    if (isset($_SESSION['enterupload']) && $_SESSION['enterupload']) {
		echo '
		<div class="link floatright" id="showupl">Upload</div>'."\n";
	}
	else {
		echo '
		<div class="link floatright" id="showlogin">Login</div>'."\n";
	}
	
	if (isset($_GET['upl']) || $_SERVER['REQUEST_METHOD'] == 'POST' AND $_SESSION['enterupload']) {
		echo "<script type=\"text/javascript\">showupl();</script>";
	}
?>
	</div>
</body>
</html>

