<!DOCTYPE html>
<html lang="en">
<head>
	<script src="js_funcs.js"></script>
    	<meta charset="UTF-8">
	<?php 
	include('general_funcs.php'); 
	
	
	
	?>
    <link rel="stylesheet" type="text/css" href="MainCss.css">
	<link rel="stylesheet" type="text/css" href="searchBox.css">
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

<!-- search form 3 -->
<div id="top_songpage" class="container_optionspage">
            <div id="page">
			 <div id="content">
                <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;" height="103">

                    <tr>
                        <td valign="left" style="padding-top:20px; padding-left:220px;width: 830px;">
			
			
							
						
<form id="search-form_3">
 <label>Search artist/band:</label>
<input type="text" class="search_3" name="artist_band" />
<input type="submit" class="submit_3" value="Search" />
</form>

<form id="search-form_3">
 <label>  Search song:</label>
<input type="text" class="search_3" name="song"/>
<input type="submit" class="submit_3" value="Search" />
</form>
<form id="search-form_3">
<label>Search album:</label>
<form id="search-form_3">
<input type="text" class="search_3" name="album"/>
<input type="submit" class="submit_3" value="Search" />
</form>

<div class ="scrollsection6_songpage">
<?php
 
if (!empty($_REQUEST['artist_band'])){

$term1 = "%".$_REQUEST['artist_band']."%";
get_artist_band_results($term1);

}

 
if (!empty($_REQUEST['song'])){
	
	
$term1 = "%".$_REQUEST['song']."%";
get_song_results($term1);
}


if (!empty($_REQUEST['album'])) {
	
	
$term1 = "%".$_REQUEST['album']."%";
get_album_results($term1);
            
}	
	



?>

	
							</div>	
							</div>
							</div>

<div class ="scrollsection_searchpage">
Notice that some information is missing? <br>You can insert new information by clicking <a href="new_data.php"> here</a>. </div>
							</div>
							
							
</body>
</html>