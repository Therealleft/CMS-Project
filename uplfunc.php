<?php
	error_reporting(E_ALL); 
	
	//Uploadfunctions:
	function checkUpload($myFILE, $file_extensions, $mime_types, $maxsize, $ordner) 
	{ 
		$errors = array(); 

		switch ($myFILE['error']){ 
			case 1: $errors[] = "Wähle eine Datei aus, die <b>kleiner als ".ini_get('upload_max_filesize')."</b> ist."; 
					break; 
			case 2: $errors[] = "Wähle eine Datei aus, die <b>kleiner als ".$maxsize/(1024*1024)." MB</b> ist.";
					break; 
			case 3: $errors[] = "Die Datei wurde nur teilweise hochgeladen."; 
					break; 
			case 4: $errors[] = "Es wurde keine Datei ausgewählt."; 
					return $errors; 
					break; 
			default : break; 
		} 
		//MIME-Type prüfen 
		if(count($mime_types)!=0 AND !in_array(strtolower($myFILE['type']), $mime_types)){ 
			$fehler = "Falscher MIME-Type (".$myFILE['type'].").<br />". 
					  "Erlaubte Typen sind:<br />\n"; 
			foreach($mime_types as $type) 
				$fehler .= " - ".$type."\n<br />"; 
			$errors[] = $fehler; 
		} 
		//Dateiendung prüfen 
		if($myFILE['name']=='' OR (count($file_extensions)!=0 AND !in_array(strtolower(getExtension($myFILE['name'])), $file_extensions))){ 
			$fehler = "Falsche Dateiendung (".getExtension($myFILE['name']).").<br />". 
					  "Erlaubte Endungen sind:<br />\n"; 
			foreach($file_extensions as $extension) 
				$fehler .= " - ".$extension."\n<br />"; 
			$errors[] = $fehler; 
		} 
		//Dateigröße prüfen 
		if($myFILE['size'] > $maxsize){ 
			$errors[] = "Datei zu groß (".sprintf('%.2f',$myFILE['size']/(1024*1024))." MB).<br />". 
						"Erlaubte Größe: ".$maxsize/(1024*1024)." MB\n"; 
		}
		//Dateiexistenz prüfen
		if(file_exists($ordner.$myFILE['name'])){
			$errors[] = $myFILE['name']." existiert bereits im Zielordner.";
		}
		return $errors; 
	} 

	//gibt die Dateiendung einer Datei zurück 
	function getExtension ($filename) 
	{ 
		if(strrpos($filename, '.')) 
			 return substr($filename, strrpos($filename, '.')+1); 
		return false; 
	}

	//prüft ob ein Projekt schon angelegt wurde
	function project_exists($proname){
		$query = mysql_query("SELECT proname FROM projektdb ORDER BY ID DESC");
		while($row = mysql_fetch_array($query))	{
			if(strcasecmp($row['proname'], $proname)==0) return false;
		}
		return true;
	}

	//erstellt Verzeichnis nach Jahr und Monat der Dateierstellung, wahlweise auch nach Projekt
	function dirmanager($birth, $project){
		$year = date("Y",$birth);
		$month = date("m",$birth);
		
		$basedir = './uploads/images/';
		if($project!='0'){
			$basedir = './uploads/projects/';
			$prodir = $basedir.$project;
			if(!is_dir($prodir)){
				mkdir($prodir);
			}
			$basedir = $prodir.'/';
		}
		
		if($birth!=0){
			$dir = $basedir.$year;
			$rdir = $dir.'/'.$month;
					
			if(!is_dir($rdir)){
				if(!is_dir($dir)){
					mkdir($dir);
				}
				mkdir($rdir);
			}		
			return $rdir.'/';
		}
		else {return $basedir;}
	}

	//erstellt ein Thumbnail mit den Maximalausmaßen newsx und newsy
	function thumbmaker($name, $dir, $newsx, $newsy, $nameplus){
		$size = getImageSize($dir.$name);
		
		if($size[2]==1) { 
			$src_img = ImageCreateFromGIF($dir.$name);		
		}
		elseif($size[2]==2) { 
			$src_img = imagecreatefromjpeg($dir.$name);
		}
		elseif($size[2]==3) { 
			$src_img = ImageCreateFromPNG($dir.$name);
		}
		else { return false; }
			
		if($size[0] < $newsx && $size[1] < $newsy){ 
			$newsx = $size[0]; 
			$newsy = $size[1];
		} 
		elseif($newsx==$newsy && $size[0]!=$size[1]){
			if($size[0]<$size[1]){
				$fromtop = floor(($size[1]-$size[0])/2);
				$dst_img2 = imagecreatetruecolor($size[0], $size[0]);
				imagecopy($dst_img2, $src_img, 0, 0, 0, $fromtop, $size[0], $size[0]);
				$size[1] = $size[0];
			}
			else {
				$fromleft = floor(($size[0]-$size[1])/2);
				$dst_img2 = imagecreatetruecolor($size[1], $size[1]);
				imagecopy($dst_img2, $src_img, 0, 0, $fromleft, 0, $size[1], $size[1]);
				$size[0] = $size[1];
			}
			$src_img = $dst_img2;			
		}
		else{
			$ratio = $size[0]/$size[1];	
			if ($newsx/$newsy > $ratio) { $newsx = $newsy*$ratio; } 
			else { $newsy = $newsx/$ratio;}
		}
		
		$dst_img = imagecreatetruecolor($newsx, $newsy);
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $newsx, $newsy, $size[0], $size[1]);
		
		if($size[2]==1) { 
			ImageGIF($dst_img, $dir.$nameplus.$name);
		}
		elseif($size[2]==2) { 
			imagejpeg($dst_img, $dir.$nameplus.$name, 100);
		}
		elseif($size[2]==3) { 
			ImagePNG($dst_img, $dir.$nameplus.$name, 0);
		}
		else { return false; }
		
		imagedestroy($src_img);
		imagedestroy($dst_img);
		if(isset($dest_img2)){imagedestroy($dst_img2);}
		
		return true;
	}
?>