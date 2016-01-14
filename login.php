<?php
	session_start();
	if (!isset($_SESSION['time'])){
		$_SESSION['time'] = time();
	}
	if (!isset($_SESSION['fail'])){
		$_SESSION['fail'] = 0;
	}
	
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['formtype'])) {
		$passlog = $_POST['loginpw'];
		$namelog = $_POST['loginname'];

		if ($passlog == 'sushi' && $namelog == 'fuji') {
			$_SESSION['enterupload'] = true;

			if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
				if (php_sapi_name() == 'cgi') {
					header('Status: 303 See Other');
				}
				else {
					header('HTTP/1.1 303 See Other');
				}
			}

			header('Location: index.php?upl');
			exit;
		}
		else {
			$_SESSION['enterupload'] = false;
			$_SESSION['fail'] += 1;
			if ($_SESSION['fail'] == 3){
				$_SESSION['time'] = time()+60*5;
				$_SESSION['fail'] = 0;
			}
		}
	}
?>

