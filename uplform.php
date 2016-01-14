<?php			
	echo'		<form name="uplform" action="' . $_SERVER['PHP_SELF'].'?';
		if (isset($_GET['page'])){echo'page='.$_GET['page'].'&';}
		if (isset($_GET['cat'])){echo'cat='.$_GET['cat'].'&';}
		if (isset($_GET['pio'])){echo'pio='.$_GET['pio'].'&';}
		echo'upl" method="post" enctype="multipart/form-data">';
?>
					<select name="select" onchange="selectupl(this)" size="1">
						<option value="uplsin">Single</option>
						<option value="uplscr">Script</option>
						<option value="uplav">AudioVideo</option>
						<option value="uplpro">Projekt</option>
					</select>
	
					<div id="beginuplform">
						<p><label for="title">Titel:</label><br/>
						<input id="title" type="text" name="title" /></p>
							
						<p>Erstellungsdatum:<br/>
						<input type="text" name="birth" id="datepicker" /></p>
						
<?php
	$arr2 = array();
	$query = mysql_query("SELECT proname FROM projektdb");
	while($row = mysql_fetch_array($query))	{
		$arr2[] = $row['proname'];
	}
	$count2 = count($arr2);
	
	echo '				<p>Projektname:<br/>
						<select id="pro" name="pro" size="1" onchange="selectpro(this)">
							<option value="0">ohne</option>';
	for($i=0;$i<$count2;$i++){
		echo '				<option value="'.$arr2[$i].'">' . $arr2[$i] . '</option>';
	}	
	echo'				</select></p>
						
						<p><label for="gdescr">Beschreibung:</label><br/>
						<textarea id="gdescr" name="descr" rows="5" cols="1"></textarea></p>
					</div>
					
					<div id="uplsin">

					<input type="hidden" name="MAX_FILE_SIZE" value="' . $maxsize . '" />';
?>						
						<p>Wähle das hochzuladende Bild aus:<br/>
						<input id="pic" type="file" name="pic" /></p>
						
						<p>Typ:<br/>
						<select id="gtype" name="type" size="1">
							<option value=""></option>
							<option value="1">3D Art</option>						
							<option value="2">Character Design</option>
							<option value="3">Environment Design</option>
							<option value="4">Fan Art</option>
							<option value="5">Matte Painting</option>
							<option value="6">Print Design</option>
							<option value="7">Vehicle Design</option>
							<option value="8">Webdesign</option>						
						</select></p>
					</div>
				
					<div id="uplscr">
						<p><label for="script">Text:</label><br/>
						<textarea id="script" name="script" rows="10" cols="1" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"></textarea></p>
						<input type="button" id="setnext" value="Seitenumbruch" />
						vor die erste Zeile der neuen Seite
					</div>
				
					<div id="uplav">
						<p><label for="gdescr">Lange Beschreibung:</label><br/>
						<textarea id="gdescr" name="longdescr" rows="5" cols="1"></textarea></p>
						
						<p>Plattform:<br/>
						<select id="mtype" name="mtype" size="1">
							<option value=""></option>
							<option value="1">YouTube</option>						
							<option value="2">SoundCloud</option>						
						</select></p>
						
						<p>Medialink:<br/>
						<input id="medialink" type="text" name="mlink" /></p>
					</div>
					
					<div id="uplpro">
						<p><label for="mkpro">Projektname:</label><br/>
						<input id="mkpro" type="text" name="proname" /></p>
						
						<p>Projektgruppe:<br/>
						<select id="gtype" name="procat" size="1">
							<option value=""></option>
							<option value="1">Comic</option>						
							<option value="2">Gamedesign</option>
							<option value="3">Storyboards</option>							
						</select></p>
					</div>
				
					<div id="enduplform">
						<p><label for="pw">Passwort:</label><br/>
						<input id="pw" type="password" name="pw" value="" /></p>
						
						<p><input id="submit" type="submit" name="submit" value="Submit" /></p>	
					</div>
				</form>