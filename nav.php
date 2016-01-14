		<div id="nav">
			<div id="logobox">
				<div id="logoself">
					<a href="index.php">
						<img src="gfx/km_logo.png" alt="Kissing Muse"/>
						<p>Kissing <span class="mag">Muse</span></p>
					</a>
				</div>					
			</div>
			<div id="menuholderbox">
				<div id="menutween">
					<h2>
<?php
if (isset($_GET['page']) && isset($_GET['pcat'])){
	switch ($_GET['pcat']) {
		case 1:	echo 'Comic';break;
		case 2:	echo 'Gamedesign';break;
		case 3:	echo 'Storyboards';break;
		default: echo '404';break;
	}
}				
elseif (isset($_GET['page']) && isset($_GET['cat'])){
	switch ($_GET['cat']) {
		case 1:	echo '3D Art';break;
		case 2:	echo 'Character Design';break;
		case 3:	echo 'Environment Design';break;
		case 4:	echo 'Fan Art';break;
		case 5:	echo 'Matte Painting';break;
		case 6:	echo 'Print Design';break;
		case 7:	echo 'Vehicle Design';break;
		case 8:	echo 'Webdesign';break;
		default: echo '404';break;
	}
}
elseif (isset($_GET['page'])){
	switch ($_GET['page']) {
		case 'ga':	
		case 'gasin':
		case 'gaov':	echo 'Single Works';break;
		case 'pr':	
		case 'prsin':	
		case 'prov':	echo 'Projects';break;
		case 'sc':	
		case 'scsin':	echo 'Scripts';break;
		case 'av':	
		case 'avsin':	echo 'Audio & Video';break;
		case 'am':		echo 'About Me';break;
		default: echo '404';break;
	}
}
else echo'Recent Works';
	
?>					
					</h2>
				</div>			
				<div id="menuleft"></div>
				<div id="menuright"></div>
			</div>
			<div id="navbox">
				<div class="navpoint">
					<div class="navdot">
						<a href="index.php">Recent</a>
					</div>
					<div class="spacer"></div>
				</div>
				<div class="navpoint">
					<div class="navdot">
						<a href="index.php?page=gaov">Single Works</a>
					</div>
					<div class="spacer"></div>
					<div class="dropdown">
						<a href="index.php?page=ga&cat=1"><p>3D Art</p></a>
						<a href="index.php?page=ga&cat=2"><p>Character Design</p></a>
						<a href="index.php?page=ga&cat=3"><p>Environment Design</p></a>
						<a href="index.php?page=ga&cat=4"><p>Fan Art</p></a>
						<a href="index.php?page=ga&cat=5"><p>Matte Painting</p></a>
						<a href="index.php?page=ga&cat=6"><p>Print Design</p></a>
						<a href="index.php?page=ga&cat=7"><p>Vehicle Design</p></a>
						<a href="index.php?page=ga&cat=8"><p>Webdesign</p></a>
					</div>
				</div>
				<div class="navpoint">
					<div class="navdot">
						<a href="index.php?page=prov">Projects</a>
					</div>
					<div class="spacer"></div>
					<div class="dropdown">
						<a href="index.php?page=pr&pcat=1"><p>Comic</p></a>
						<a href="index.php?page=pr&pcat=2"><p>Gamedesign</p></a>
						<a href="index.php?page=pr&pcat=3"><p>Storyboards</p></a>
					</div>
				</div>
				<div class="navpoint">
					<div class="navdot">
						<a href="index.php?page=sc">Scripts</a>
					</div>
					<div class="spacer"></div>
				</div>
				<div class="navpoint">
					<div class="navdot">
						<a href="index.php?page=av">Audio/Video</a>
					</div>
					<div class="spacer"></div>
				</div>
				<div class="navpoint">
					<div class="navdot">
						<a href="index.php?page=am">About Me</a>
					</div>
					<div class="spacer"></div>
				</div>
			</div>
		</div>