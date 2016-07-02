<!DOCTYPE html>
<html lang="en">
<head>
	<script src="js_funcs.js"></script>
    <meta charset="UTF-8">
	<?php 
	include('general_funcs.php');
	include ('showVideo.php');
	$song = isset($_GET['song'])?$_GET['song']:$_COOKIE['song'];
	$artist = isset($_GET['artist'])?$_GET['artist']:'';
	
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



        <div id="top_songpage" class="container_optionspage">
            <div id="page">
			 <div id="content">
                <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;" height="103">

                    <tr>
                        <td valign="top" style="padding-top:20px; padding-left:20px; width: 830px;">
                           
							<div class ="scroll">
							
							<h4> 
							<?php 
								print_song_name($song);
							?>
							</h4>
							<br><br>
							
							<div class ="scrollsection1_songpage">
							<h1><u> Short info: </u></h1>	
							<?php  
								print_song_info($song);
							?>
							</div>		
				
							
							<div id = "player" class ="scrollsectionvideo_songpage">	
							<h1><u>Video:</u></h1>
							<?php
							if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
								$artist_name = $artist;
							}else{
								
								$artist_name = "song";
							}
							$song_name = get_song_name_php($song);
							
							$sFile=getIdFromName($song_name,$artist_name); ?>
							
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
							
							<div class ="scrollsection2_songpage">	
							<h1><u>Year:</u></h1>
							<?php  
								print_song_year($song);
							?>
							<br><br>
							
							<h1><u>Album: </u></h1>
							<?php  
								print_song_album($song);
							?>
							</div>		
					
							<div class ="scrollsection3_songpage">	
							<h1><u>Suggested other songs you may like:</u></h1>
							<?php
								print_suggested_songs($song);												
							?>	
							
								
							</div>	
						<div class ="scrollsection4_songpage">
					
						<h1><u>Did you know...? </u></h1>
						The following songs have a common genre with this song and 3 more different genres: <br>
							<?php
								print_did_you_know($song);											
							?>
						
						</div>

						<div class ="scrollsection_update">
						<b>Notice that some information about the song is missing? You can help us updating our database by clicking
						<?php update_song($song);?>.</b>

						</div>
							
						
						
						</div>
            </div>
        </div>
    </div>
</body>
</html>