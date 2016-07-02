<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<?php 
	include('general_funcs.php');
	$album = isset($_GET['album'])?$_GET['album']:$_COOKIE['album'];	
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
								print_album_name($album);
							?>
							</h4>
							<br><br>
							
							<div class ="scrollsection1_songpage">
							<h1><u> Short info: </u></h1>	
							<?php 
								print_album_info($album);
							?>
							</div>		
										
							<div class ="scrollsection5_songpage">	
							<h1><u>Release date:</u></h1>
							
							<?php 
								print_album_release_date($album);
							?>
							<br><br>
							<h1><u>Album type:</u></h1>
							<?php 
								print_album_type($album);
							?>														
							</div>
														
							<div class ="scrollsection_update_medium">
							<b>Notice that some information about the album is missing? You can help us updating our database by clicking 
							<?php update_album($album);?>.</b>
							</div>
		
						</div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>