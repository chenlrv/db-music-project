<!DOCTYPE html>
<html lang="en">
<head>
	<script src="js_funcs.js"></script>
    <meta charset="UTF-8">
	<?php 
	include('general_funcs.php'); 
	?>
	
    <link rel="stylesheet" type="text/css" href="MainCss.css">
    <title>Music Wizard</title>
	<?php $genre = isset($_GET["genre"])?$_GET["genre"]:$_COOKIE["genre"]; ?>
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

        <div id="top_optionspage" class="container_optionspage">
            <div id="page">
			 <div id="content">
                <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;" height="103">

                    <tr>
                        <td valign="top" style="padding-top:20px; padding-left:20px; width: 830px;">
                           
						<div class ="scroll">
							
						<h4>
						<?php 				
							print_genre_name($genre);
						?> 
						</h4>
						<br><br>
														
						<div class ="scrollsection1">
						
						<h1><u> Music genre info: </u></h1>							
																				
						<?php 				
							print_genre_info($genre);							
						?>
						<br><br>
						
						<h1><u>Most popular years: </u></h1>
						<?php 										
							print_genre_popular_years($genre);																
						?>	
						<br><br>
						
						<h1><u>Start year of the genre: </u></h1>
						
						<?php 
							print_genre_start_year($genre);		
						?>
						<br><br>
						
						<h1><u>Most active band of the genre: </u></h1>
											
						<?php 
							 print_genre_most_active_band($genre);
						?>
						<br><br>
						
						<h1><u>Most active artist of the genre: </u></h1>
												
						<?php 
							print_genre_most_active_artist($genre);	
						?>
												
						</div>
						<br>
						
						<div class ="scrollsection2">	
                      	<h1><u>Stylistic origins:</u></h1>				
						
						<?php    
							print_genre_stylistic_origins($genre);
						?>
						<br><br>
						
						<h1><u>Sub-genres:</u></h1>
						
						<?php  
							print_genre_subgenres($genre)
						?>
						
						<br><br>
						<h1><u> Derivated genres: </h1></u>
						<?php
							print_genre_derivated($genre);
						?>
						
						</div>
						
						<div class ="scrollsection3">	
						<h1><u> Artists of this genre:</h1></u>
						<?php 
							print_genre_artists($genre);												
						?>
				  
						<br><br>
						<h1><u>Bands of this genre:</h1></u>
						
						<?php 
							print_genre_bands($genre);
						?>
						
						</div>
						
						<div class ="scrollsection4">	
						
						<h1><u>Songs of this genre: </u></h1>
						<?php	
							print_genre_songs($genre);
						?>		
																	
						<br><br>
						<h1><u>Albums of this genre: </u></h1>
						<?php  
							print_genre_albums($genre);
						?>			

						</div><br><br>	
										
						 <?php 
							print_suggested_genres($genre);				
						?>
						
						</div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>