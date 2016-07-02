
<!DOCTYPE html>

<html>
	<head>
		<title>update album</title>
		<link rel="stylesheet" type="text/css" href="MainCss.css">
	</head>

	<?php
		include("data_insert_funcs.php");
	
		//get album information
		$album_id = $_GET["album"];
	
		$row= get_album_information($album_id);
		$album_name = $row["name"];
		$desc = $row["comment"];
		$type = $row["type"];
		$year = $row["released"];


		if(isset($_POST["go_album"])){
			insert_album($album_id,1);
			echo "<script> window.location.replace('Album.php?album=".$album_id."') </script>";
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
                        <td valign="top" style="padding-top:20px; padding-left:20px; width: 830px;">
                           
			<div class ="scroll">

			

			<img src="update_album.gif">
			<br><div class ="scrollsection8_songpage">
			Here you can update the album's information. <br>
			Notice that you can only update album fields that currently don't contain any information, <br>in order to assure that correct information will not be changed.
			<form action="" method="post" enctype="multipart/form-data" id="insert_album">
						
					<div><br>
						
						<label><b> Album Name </b></label>
						<input type="text" name="alb_name" placeholder= "Album name" value="<?php echo $album_name;?>" readOnly />
						<br><br>
					
						<label><b> Description </b></label>
						<?php if($desc != NULL){ $disable="disabled";} else {$disable="";} ?>
						<textarea name="alb_description" form="insert_album" placeholder="Add a description..." maxlength="388" 
						<?php echo $disable; ?>> <?php if($desc!=NULL) echo $desc;?> </textarea>
						<br><br>
					
						<label><b> Release Year </b></label>
						<?php if($year != NULL){ $disable="disabled"; } else{$disable="";} ?>
						<input type="number" name="rel_year" placeholder= "Choose year" min="1800" max="2016" 
						value="<?php if($year != NULL) echo $year;?>" <?php echo $disable; ?> />
						<br><br>

						<label><b> Album type </b></label>
						<?php if($type != NULL){ $disable="disabled"; } else{$disable="";} ?>
						<input type="text" name="alb_type" placeholder= "insert type" value="<?php if($type != NULL) echo $type;?>"
						<?php echo $disable; ?>/>
						<br>
						

					</div>
						
					<div id="submit">
						<input type="submit" value="Update" name="go_album" />
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
