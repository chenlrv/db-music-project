<!DOCTYPE html>

<html>
	<head>
		<title>Update Song</title>
		<link rel="stylesheet" type="text/css" href="MainCss.css">
	</head>

	<?php
		include("data_insert_funcs.php"); 

		//get artist information
		$song_id = $_GET["song"];

		$row= get_song_information($song_id, "Songs");
		$name = $row["name"];
		$desc = $row["comment"];
		$year = $row["year"];


		if(isset($_POST["go_song"])){
			insert_song($song_id,1);
			echo "<script> window.location.replace('Song.php?song=".$song_id."') </script>";

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
                        <td valign="top" style="padding-top:10px; padding-left:20px; width: 830px;">
                           
			<div class ="scroll">
		<IMG src="update_song.gif">
		<br><div class ="scrollsection8_songpage">
		Here you can update the song's information. <br>
		Notice that you can only update song fields that currently don't contain any information, <br>in order to assure that correct information will not be changed.
		<form action="" method="post" enctype="multipart/form-data" id="insert_song">
				
			<div>	<br>
				<label><b> Song Name </b></label>
					<input type="text" name="song_name" placeholder= "Song name" value="<?php echo $name;?>" readOnly/> 

					<br><br>			
					<label><b> Description </b></label>
					<?php if($desc != NULL){ $disable="disabled";} else {$disable="";} ?>
					<textarea name="song_description" form="insert_song" placeholder="Add a description..." maxlength="388"
					<?php echo $disable; ?>> <?php if($desc!=NULL) echo $desc;?> </textarea>
					
					<br><br>
					<label><b> Release Year </b></label>
					<?php if($year != NULL){ $disable="disabled"; } else{$disable="";} ?>
					<input type="number" name="rel_year2" placeholder= "Choose year" min="1800" max="2016"
					value="<?php if($year != NULL) echo $year;?>" <?php echo $disable; ?> />

			</div>

				<br>	
				<div id="submit">
					<input type="submit" value="Update" name="go_song" />
					
				</div>
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
