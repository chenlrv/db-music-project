

	
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<?php 
	include('config.php'); 
	
	$artist = $_GET['band'];
	?>
    <link rel="stylesheet" type="text/css" href="MainCss.css">
    <title>options</title>
	
</head>
<body>

<div id="header" class="container">
    <div id="logo">
        <h1><a href="#">Prospect</a></h1>
    </div>
    <div id="menu">
        <ul>
            <li><a href="#" accesskey="1" title="">Homepage</a></li>
            <li><a href="#" accesskey="2" title="">Portfolio</a></li>

        </ul>
    </div>
</div>
<div id="wrapper" class="container">
    <div id="page">
        <div id="wrapper" class="container">
            <div id="page">
                <div id="content">
                    <h2>Selected band/artist:</h2>
					<?php 
						
						$result = $mysqli->query ("SELECT * FROM band 
														WHERE band.ID ={$band}");
															
						$row = $result->fetch_array();
						echo $row['name'];
						
							
					?>
                    <h2> </h2>
                    <h2>Short info:</h2>
					<?php 
						
						$result = $mysqli->query ("SELECT * FROM band 
														WHERE band.ID ={$band}");
															
						$row = $result->fetch_array();
						echo $row['comment'];
						
							
					?>
                    <h2></h2>
                    <h2>Top clips:</h2>
                    <h2></h2>
                    <h2>Suggested other genres:</h2>
                    <h2></h2>
                    <h2>Suggested other bands:</h2>
					<h2></h2>
					 <h2>Suggested other artists:</h2>
					<?php 
					$result = $mysqli->query ("
					SELECT a.name as name,a.ID as ID, count(ga.MusicGenre) as num
						FROM MusicalArtist as a, musicalartist_musicgenre as ga
						WHERE a.id <> {$artist} AND
						a.ID = ga.MusicalArtist AND
						ga.MusicGenre IN (SELECT gea.MusicGenre
									FROM MusicalArtist as ar, musicalartist_musicgenre as gea
									WHERE ar.id = {$artist} AND
										ar.ID = gea.MusicalArtist) 
										GROUP BY a.name
										ORDER BY num DESC
										LIMIT 5");
										
						

							while($row = $result->fetch_array()) {
							 echo  "<a   id ='herfCom' name ='herfCom' href='ArtistPage.php?artist=".$row['ID']."' onClick='DoPost();' value='".$row['name']."'>".$row['name']."</a>";
							 echo "  ,  ";
							}
							if($result === FALSE) { 
							die(mysql_error()); // TODO: better error handling
							}						
						
				?>	
				<script language="javascript" > 

							   function DoPost(){
								 var art= document.getElementById("herfCom").value;
								xhttp = new XMLHttpRequest();
							   xhttp.open("get", "ArtistPage.php?artist="+art, true);
								xhttp.send();	
							   }

							</script>
                </div>
            </div>
        </div>


</body>
</html>