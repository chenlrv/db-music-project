<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="MainCss.css">
	     	<title>Music Wizard</title>
	</head>

	<?php
		include("data_insert_funcs.php");

		

		if(isset($_POST["go_artist"])){
			insert_artist_or_band(null, 0);
		}

		if(isset($_POST["go_album"])){
			insert_album(null, 0);
		}

		if(isset($_POST["go_song"])){
			insert_song(null, 0);
		}
	?>
	

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		$("#parent_cat1").change(function() {
			$(this).after('<div id="loader"></div>');
			$.post('loadsubcat.php?parent_cat=' + $(this).val(), function(data) {
				$("#sub_cat1").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
					});
				});	
	    		});
		});
	</script>


	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		$("#parent_cat2").change(function() {
			$(this).after('<div id="loader"></div>'); 
			$.post('loadsubcat.php?parent_cat=' + $(this).val(), function(data) {
				$("#sub_cat2").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
					});
				});	
	    		});
		});
	</script>


	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		$("#parent_cat3").change(function() {
			$(this).after('<div id="loader"></div>'); 
			$.post('loadsubcat.php?parent_cat=' + $(this).val(), function(data) {
				$("#sub_cat3").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
					});
				});	
	    		});
		});
	</script>
	


	


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
 <div id="wrappertest" class="container">
            <div id="page">
	 <div id="content">
 	<div id="topwrappertest">
	<div id="page">
                <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;" height="103">

                    <tr>
                        <td valign="top" style="padding-top:20px; padding-left:20px; width: 830px;">
                           
							<div class ="scroll">
	
		
		

		
	<!-- new artist/band insert form -->
	<h2> New Artist/Band </h2>
	<form action="" method="post" enctype="multipart/form-data" id="insert_artist">
			
			<div>
				<input type="radio" name="is_artist1" value="artist" checked> Artist 
				<input type="radio" name="is_artist1" value="band"> Band <br>

				<label><b> Name </b></label>
				<input type="text" name="name" placeholder= "The artist's name" required="" />
			
				<label><b> Description </b></label>
				<textarea name="description" form="insert_artist" placeholder="Add a description..." maxlength="388"></textarea>
			
				<label><b> Active Years </b></label>
				<input type="number" name="start_year" placeholder= "Choose start year" min="1800" max="2016"/>
				<input type="number" name="end_year" placeholder= "Choose end year" min="1800" max="2016"/>
			</div>
      
      <div>
           <label><b> Image link </b></label>
           <input type="text" name="img_link1" placeholder= "link to image" />
      </div>

			<div>
				<label for="category"><b>Genre</b></label>
				<select name="parent_cat1" id="parent_cat1" style="width:185px;" required="">
				<option></option>
																									
					<?php 
						$query_parent = $mysqli->query("SELECT * FROM MusicGenreTop ORDER BY name");
						while($row = $query_parent->fetch_array()): ?>
						<option value="<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></option>
					<?php endwhile; ?>
				</select>

				<label><b>Sub-Genre</b></label>
				<select name="sub_cat1" id="sub_cat1" style="width:185px;" required=""></select>
				
			</div> 
				
			<div id="submit">
				<input type="submit" value="Add" name="go_artist" />
			</div><br>

	</form>


	<!-- new album insert form -->
	<h2> New Album </h2>
	<form action="" method="post" enctype="multipart/form-data" id="insert_album">
				
			<div>
				<label><b> Of the </b></label>
				<input type="radio" name="is_artist2" value="artist" checked> Artist 
				<input type="radio" name="is_artist2" value="band"> Band 
				<label><b> Named </b></label>
				<input type="text" name="art_name" placeholder= "Artist name" required="" /> <br>

				<label><b> Album Name </b></label>
				<input type="text" name="alb_name" placeholder= "Album name" required="" />
			
				<label><b> Description </b></label>
				<textarea name="alb_description" form="insert_album" placeholder="Add a description..." maxlength="388"></textarea>
			
				<label><b> Released Year </b></label>
				<input type="number" name="rel_year" placeholder= "Choose year" min="1800" max="2016" /><br>
				
				 <label><b> Album Type </b></label>
				<input type="text" name="alb_type" placeholder= "insert type" />
			</div>

			<div>
				<label for="category"><b>Genre</b></label>
				<select name="parent_cat2" id="parent_cat2" style="width:185px;" required="">
				<option></option>
																									
					<?php 
						$query_parent = $mysqli->query("SELECT * FROM MusicGenreTop ORDER BY name");
						while($row = $query_parent->fetch_array()): ?>
						<option value="<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></option>
					<?php endwhile; ?>
				</select>

				<label><b>Sub-Genre</b></label>
				<select name="sub_cat2" id="sub_cat2" style="width:185px;" required=""></select>
				
			</div> 
				
			<div id="submit">
				<input type="submit" value="Add" name="go_album" />
			</div><br>

	</form>


	<!-- new song insert form -->
	<h2> New Song </h2>
	<form action="" method="post" enctype="multipart/form-data" id="insert_song">
				
			<div>
				<label><b> Of the </b></label>
				<input type="radio" name="is_artist3" value="artist" checked> Artist 
				<input type="radio" name="is_artist3" value="band"> Band 
				<label><b> Named </b></label>
				<input type="text" name="art_name2" placeholder= "Artist name" required="" /> 

				<label><b> From the Album </b></label>
				<input type="text" name="alb_name2" placeholder= "Album name"/> <br>

				<label><b> Song Name </b></label>
				<input type="text" name="song_name" placeholder= "Song name" required="" /> 

							
				<label><b> Description </b></label>
				<textarea name="song_description" form="insert_song" placeholder="Add a description..." maxlength="388"></textarea>
			
				<label><b> Released Year </b></label>
				<input type="number" name="rel_year2" placeholder= "Choose year" min="1800" max="2016"/>
			</div>
      
      <div>
           <label><b> Image link </b></label>
           <input type="text" name="img_link2" placeholder= "link to image" />
      </div>

			<div>
				<label for="category"><b>Genre</b></label>
				<select name="parent_cat3" id="parent_cat3" style="width:185px;" required="">
				<option></option>
																									
					<?php 
						$query_parent = $mysqli->query("SELECT * FROM MusicGenreTop ORDER BY name");
						while($row = $query_parent->fetch_array()): ?>
						<option value="<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></option>
					<?php endwhile; ?>
				</select>

				<label><b>Sub-Genre</b></label>
				<select name="sub_cat3" id="sub_cat3" style="width:185px;" required=""></select>
				
			</div> 
				
			<div id="submit">
				<input type="submit" value="Add" name="go_song" />
			</div><br>

	</form>
            </div>
			</div>
        </div>
    </div>
    </div>
</body>
</html>