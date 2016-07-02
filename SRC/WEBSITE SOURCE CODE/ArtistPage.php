<!DOCTYPE html>
<html lang="en">
<head>
	<script src="js_funcs.js"></script>
    <meta charset="UTF-8">
	<?php 
	include ('showVideo.php');
	include('general_funcs.php');
	
	$artist = isset($_GET['artist'])?$_GET['artist']:'';
	$band =  isset($_GET['band'])?$_GET['band']:'';
	?>
    <link rel="stylesheet" type="text/css" href="MainCss.css">
    <title>Music Wizard</title>
	
</head>
<body>




<div id="header" class="container">
   
    <div id="logo"><a href="MainPage.php"><img src="final.gif" alt="Magic Wizard">
    </a>
    </div>
    <div id="menu">
        <ul>
	<li><a href="search.php" accesskey="1" title="">Search</a></li>
 	 <li><a href="AboutPage.html" accesskey="2" title="">About the site</a></li>

        </ul>
    </div>
</div>

        <div id="top_artistpage" class="container_optionspage">
            <div id="page">
			 <div id="content">
                <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;" height="103">

                    <tr>
                        <td valign="top" style="padding-top:20px; padding-left:20px; width: 830px;">
                           
							<div class ="scroll">
							
							<h4> 
							<?php 
								print_artist_name($artist, $band);
							?> 
							
							</h4>
							<br><br>
							<div class ="scrollsection1_artistnew">
							<h1><u> Short info: </u></h1>	
	
							<?php 
								print_artist_info($artist, $band);
							?>
							</div>

							<div class="scrollsection2_artistnew">
							<h1><u> Picture: </u></h1>
							<?php 
								print_artist_pic($artist, $band);
							?>	
							
							
							</div>
							
							<div class ="scrollsection6_artistnew">
							<h1><u>Featured songs:</u></h1>
							<?php 
								print_artist_featured_songs($artist, $band);						
							?>
							
							<br><br>
																			
							<h1><u>Featured albums: </u></h1>
							<?php 
								print_artist_featured_albums($artist, $band);							
							?>
							</div>

							<div class ="scrollsection5_artistnew">	
							<h1><u>Suggested other artists you may like:</u></h1>
							<?php 
								print_suggested_artists($artist, $band);									
							?>	
	
							<br><br>
							<h1><u>Suggested other bands you may like:</u></h1>
							<?php 
								print_suggested_bands($artist, $band);										
							?>	
													
							</div>

							<div class ="scrollsection4_artistnew">	
							<h1><u>Suggested other genres you may like: </u></h1>
							
							<?php 
								print_suggested_genres_artistpage($artist, $band);												
							?>								
							</div>
						
							<div id = "player" class ="scrollsection3_artistnew">	
							<h1><u>Featured video: </u></h1>
							<?php 
							$artist_name = get_artist_name_php($artist, $band);
							$band_artist_song = artist_featured_songs($artist, $band);
							$sFile=getIdFromName($artist_name,$band_artist_song); ?>
							<script>
							urlid= "<?php echo $sFile; ?>";
							// 2. This code loads the IFrame Player API code asynchronously.
							var tag = document.createElement('script');

							tag.src = "https://www.youtube.com/iframe_api";
							var firstScriptTag = document.getElementsByTagName('script')[0];
							firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

							// 3. This function creates an <iframe> (and YouTube player)
							//    after the API code downloads.
							var player;
							function onYouTubeIframeAPIReady() {
								player = new YT.Player('player', {
								height: '390',
								width: '640',
								videoId: urlid,
								events: {
									'onReady': onPlayerReady, 
								}
							});
							}

							// 4. The API will call this function when the video player is ready.
							function onPlayerReady(event) {
								event.target.stopVideo();
							}

							function stopVideo() {
								player.stopVideo();
							}
							</script>
								
							</div>
							<div class ="scrollsection_update_big">
							<?php if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
								echo"<b>Notice that some information about the artist is missing? You can help us updating our database by clicking ";
							}else{
								echo"<b>Notice that some information about the band is missing? You can help us updating our database by clicking ";
							}
								update_art_band($artist, $band);?>.</b>
							</div>							
						</div>
            </div>
        </div>
    </div>
</body>
</html>