<?php 
    error_reporting(E_ALL); 
	
	mysql_connect('localhost', 'leftspace', 'nasai') or die("Keine Verbindung möglich");
	mysql_select_db('leftspace') or die("Die Datenbank existiert nicht");
	$pass = "oyasumi";
	$timestamp = time();
	$maxsize = 10*1024*1024;
	$maxsize_m = 50*1024*1024;  
    $file_extensions = array('jpg', 'jpeg', 'gif', 'png'); 
    $mime_types = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/x-png');
	
	include('uplfunc.php');
	
	echo'
		<div id="login">';
	if (isset($_SESSION['time']) && $_SESSION['time'] <= time()) {
		echo'<form method="post" name="login" action="'.$_SERVER['PHP_SELF'].'?';
		if (isset($_GET['page'])){echo'page='.$_GET['page'].'&';}
		if (isset($_GET['cat'])){echo'cat='.$_GET['cat'].'&';}
		if (isset($_GET['pio'])){echo'pio='.$_GET['pio'].'&';}
		echo'upl">
				<input type="text" value="Username" onfocus="focusname();" name="loginname"  maxlength="10" />
				<input type="password" value="Passwort" onfocus="focuspw();" name="loginpw"  maxlength="10" />
				<input type="hidden" value="logform" name="formtype" />
				<br /><br />
				<p><input id="logsubmit" type="submit" name="submit" value="Submit" /></p>
			</form>';
	}
	else {
		echo'
			<p>Account locked</p>
			<p><input type=button value="close" onclick="showlogin()" /></p>';
	}
	
	echo'
		</div>
		<div id="upl">
			<div class="uplwhite">
				<div id="quitupl" onclick="location.href=\''.$_SERVER['PHP_SELF'];
	if (isset($_GET['page'])){echo'?page='.$_GET['page'];}
	if (isset($_GET['cat'])){echo'&cat='.$_GET['cat'];}
	if (isset($_GET['pio'])){echo'&pio='.$_GET['pio'];}
	echo'\';">x</div>';
			
    if(isset($_POST['submit'])){
	
		if($_POST['select']=="uplpro" && $_POST['proname'] == "") $error[] = 'Du hast keinen Projektnamen eingegeben!';
		if($_POST['select']=="uplpro" && $_POST['procat'] == "") $error[] = 'Du hast keine Projektkategorie ausgewählt!';
		if($_POST['select']=="uplpro" && !project_exists($_POST['proname'])){
			$error[] = 'Der Projektname ist bereits vorhanden!';
		}
		if($_POST['select']!="uplpro" && $_POST['title'] == "")$error[] = 'Du hast keinen Titel eingetragen!';
		if($_POST['select']=="uplsin" && $_POST['descr'] == "")$error[] = 'Du hast keine Beschreibung eingegeben!';
		if($_POST['select']=="uplsin" && $_POST['type'] == "")$error[] = 'Du hast keinen Typ angegeben!';
		if($_POST['select']=="uplscr" && $_POST['script'] == "")$error[] = 'Du hast keinen Text eingegeben!';
		if($_POST['select']=="uplav" && $_POST['mtype'] == "")$error[] = 'Du hast keinen Typ angegeben!';
		if($_POST['select']=="uplav" && $_POST['mlink'] == "")$error[] = 'Du hast keinen Link eingegeben!';
		if($_POST['pw'] != $pass)$error[] = 'Das Passwort ist falsch!';
		if(isset ($error) AND count($error) >= 1) {
			echo "<p>Upload-Fehler<br/><br/>\n";
			foreach($error as $v) {
				echo '<span style="color:#FF0000">'.$v."</span><br/>\n";
			}
		}
		else {
			$myPIC = $_FILES['pic']; 
			$birth = strtotime($_POST['birth']);
			if($_POST['select']=="uplpro") {$ordner = dirmanager(0, $_POST['proname']);}
			elseif($_POST['pro']!= 0) {$ordner = dirmanager($birth, $_POST['pro']);}
			else {$ordner = dirmanager($birth, 0);}
			
			$errors = array(); 
			if($_POST['select']=="uplsin"){
				$errors = checkUpload($myPIC, $file_extensions, $mime_types, $maxsize, $ordner);
			}
			if(count($errors)){ 
				echo 
					"<p>Die Datei konnte nicht gespeichert werden.<br/><br/>\n"; 
				foreach($errors as $error) 
					echo $error."<br/>\n"; 
			} 
			else {
				if($_POST['select']=="uplsin" && move_uploaded_file($myPIC['tmp_name'], $ordner.$myPIC['name'])){ 
					if(!thumbmaker($myPIC['name'], $ordner, 500, 300, "thumblarge_")){
						echo"<p>Thumbnail konnte nicht erzeugt werden.</p><br/>\n";
					}
					if(!thumbmaker($myPIC['name'], $ordner, 70, 70, "thumbsmall_")){
						echo"<p>Thumbnail konnte nicht erzeugt werden.</p><br/>\n";
					}
					mysql_query("INSERT INTO grafikdb (timestamp, dir, file, title, birth, descr, type, projekt) VALUES ('$timestamp', '$ordner', '$myPIC[name]', '$_POST[title]', '$birth', '$_POST[descr]', '$_POST[type]', '$_POST[pro]')");
					echo"<p>Die Datei wurde erfolgreich gespeichert.<br/>\n";
				}
				elseif($_POST['select']=="uplav"){
					mysql_query("INSERT INTO avdb (timestamp, title, mtype, mlink, birth, shortdescr, longdescr, projekt) VALUES ('$timestamp', '$_POST[title]', '$_POST[mtype]', '$_POST[mlink]', '$birth', '$_POST[descr]', '$_POST[longdescr]', '$_POST[pro]')");							
					echo"<p>Der Medialink wurde erfolgreich gespeichert.<br/>\n";
				}
				elseif($_POST['select']=="uplscr"){
					mysql_query("INSERT INTO scriptdb (timestamp, title, birth, script, descr, projekt) VALUES ('$timestamp', '$_POST[title]', '$birth', '$_POST[script]', '$_POST[descr]', '$_POST[pro]')");
					echo"<p>Das Script wurde erfolgreich gespeichert.<br/>\n";
				}
				elseif($_POST['select']=="uplpro"){
					mysql_query("INSERT INTO projektdb (proname, procat) VALUES ('$_POST[proname]', '$_POST[procat]')");
					echo"<p>Das Projekt wurde erfolgreich angelegt.<br/>\n";
				}
				else{ 
					echo'<p>Die Datei konnte nicht gespeichert werden.<br/> 
						Es ist ein Upload-Fehler aufgetreten.<br />'; 
				} 
			}
		}
		echo '<br/><div id="newupl"><a href="'.$_SERVER['PHP_SELF'].'?';
		if (isset($_GET['page'])){echo'page='.$_GET['page'].'&';}
		if (isset($_GET['cat'])){echo'cat='.$_GET['cat'].'&';}
		if (isset($_GET['pio'])){echo'pio='.$_GET['pio'].'&';}
		echo'upl">neuer Upload</a></div></p>'; 
    } 
    else{
		include('uplform.php');
    } 
	echo '
			</div>
		</div>';
?>