<!DOCTYPE html>
<html lang="en">
<head>
	<script src="js_funcs.js"></script>
    <meta charset="UTF-8">
	<?php 
	include('general_funcs.php');
	include ('showVideo.php');
	$song = $_GET['comp'];
	
	
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
								print_classical_name($song);
							?>
							</h4>
							<br><br>
							
							<div class ="scrollsection1_songpage">
							<h1><u> Short info: </u></h1>	
							<?php  
								print_classical_info($song);
							?>
							</div>		
				
							
							<div id = "player" class ="scrollsectionvideo_songpage">	
							<h1><u>Video:</u></h1>
							<?php
							$composer = get_classical_composer_php($song);
							if (isset($composer) && (! (composer ==''))){
								
							}else{
								
								$composer= "composition";
							}

							$song_name = get_classical_name_php($song);
							
							$sFile=getIdFromName($song_name,$composer); ?>
							
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
							<br>
							
							<div class ="scrollsection2_songpage">	
							<h1><u>Composer:</u></h1>
							<?php  
								print_classical_composer($song);
							?>
							<br><br>
															
						</div>
            </div>
        </div>
    </div>
</body>
</html>