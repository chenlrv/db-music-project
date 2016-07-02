<!DOCTYPE html>

<html>
	<head>
		<title>Update Artist-Band</title>
		<link rel="stylesheet" type="text/css" href="MainCss.css">
	</head>

	<?php

		include("data_insert_funcs.php");
		

		//get artist information
		
		if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){$is_artist="artist"; $artist_id = $_GET["artist"]; $table_name="MusicalArtist";}
		else {$is_artist="band"; $artist_id = $_GET["band"]; $table_name="Band";} 

		
				

		$row= get_artist_information($artist_id,$table_name);
		$artist_name = $row["name"];
		$desc = $row["comment"];
		$start = $row["activeYearsStartYear"];
		$end = $row["activeYearsEndYear"];
		$image = $row["imageLink"];





		if(isset($_POST["go_artist"])){
			insert_artist_or_band($artist_id, 1);
			echo "<script> window.location.replace('ArtistPage.php?".$is_artist."=".$artist_id."') </script>";
		}

	?>
	
	
	<body>
	<div id="header" class="container">
   
   	 <div id="logo"><a href="MainPage.php"><img src="final.gif" alt="Magic Wizard"></a></div>
   	 <div id="menu">
       	 <ul>
	<li><a href="search.php" accesskey="1" title="">Search</a></li>
 	<li><a href="AboutPage.html" accesskey="2" title="">About the site</a></li>
        </ul>
    	</div>
	</div>
 	<div id="wrappertest" class="container">
	  <div id="page">
	    <div id="content">
 	       <div id="topwrappertest">
	          <div id="page">
                  <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;" height="103">

                    <tr>
                        <td valign="top" style="padding-top:-10px; padding-left:20px; width: 830px;">
                           
			<div class ="scroll">


			<!-- update artist/band form -->
			<img src="update_artist2.gif">
			<br><div class ="scrollsection8_songpage">
			Here you can update the artist/band's information. <br>
			Notice that you can only update artist/band fields that currently don't contain any information, <br>in order to assure that correct information will not be changed.

			<form action="" method="post" enctype="multipart/form-data" id="insert_artist">
			
			<div>	
				<input type="hidden" name="is_artist1" value="<?php echo $is_artist;?>" /> 
				<br><br>
				
				
				<label><b> Name </b></label>
				<input type="text" name="name" placeholder= "The artist's name" value="<?php echo $artist_name;?>" readOnly/>
				
				
				<label><b> Description </b></label>
				<?php if($desc != NULL){ $disable="disabled";} else {$disable="";} ?>
				<textarea name="description" form="insert_artist" placeholder="Add a description..." maxlength="388" 
				<?php echo $disable; ?>> <?php if($desc!=NULL) echo $desc;?> </textarea>
				
					
				<br><br>
				<label><b> Active Years </b></label>
				<?php if($start != NULL){ $disable="disabled"; } else{$disable="";} ?>
				<input type="number" name="start_year" placeholder= "Choose start year" min="1800" max="2016" 
				value="<?php if($start != NULL) echo $start;?>" <?php echo $disable; ?>/>

				<?php if($end != NULL){ $disable="disabled"; } else{$disable="";} ?>
				<input type="number" name="end_year" placeholder= "Choose end year" min="1800" max="2016" 
				value="<?php if($end != NULL) echo $end;?>" <?php echo $disable; ?>/>
			</div>
      			<br>
	      		<div>
	          	<label><b> Image link </b></label>
	          	<?php if($image != NULL){ $disable="disabled"; } else{$disable="";} ?>
	           	<input type="text" name="img_link1" placeholder= "link to image" 
				value="<?php if($image != NULL) echo $image;?>" <?php echo $disable; ?>/>
	     		</div>
				
			<br>
			<div id="submit">
				<input type="submit" value="update" name="go_artist" />
			</div>

			</form>
		      </div>
	       	   </div>
                </div>
             </div>
          </div>
       </div>
   </body>
</html>
