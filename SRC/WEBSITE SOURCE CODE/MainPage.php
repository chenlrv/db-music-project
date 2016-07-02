<?php 
include('general_funcs.php'); 

$query_parent = get_genres();

	if(isset($_POST["go"])){
			if (isset($_POST["parent_cat"]) && (!$_POST["parent_cat"] =='')){
				$sub_gen= isset($_POST["sub_cat"])? $_POST["sub_cat"]:'';
							
					$cookie_name = "genre";
					
					$cookie_value = $sub_gen;
					setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");   
					header("Location: OptionsPage.php");
			}else{
					echo "<script type='text/javascript'>alert('Please selet a genre, and try again!');</script>";
				
				}
	}
	

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<script src="js_funcs.js"></script>
    <meta charset="UTF-8">

    <link rel="stylesheet" type="text/css" href="MainCss.css">

    <title>Music Wizard</title>
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js""></script>
	<script type="text/javascript">
	$(document).ready(function() {
 
	$("#parent_cat").change(function() {
		 if ($(this).val())
		  {
			$("input[name='go']").removeAttr('disabled');
		  }else{
			$("input[name='go']").attr('disabled','disabled');
			}
		$(this).after('<div id="loader"></div>');
		$.post('loadsubcat.php?parent_cat=' + $(this).val(), function(data) {
			$("#sub_cat").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
 
});
</script>
	
	
	
	
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

<div id="wrapper" class="container">
    <div id="page">
        <div id="content">

            <div id="topwrapper">
                <div id="page">
                    <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;" height="103">

                        <tr>
                            <td valign="top" style="padding-top:20px; padding-left:20px; width: 830px;">
                                <font color="black", size="3"><b>Welcome to Music Wizard!</b> <br>

                                To get started, please choose music genre and music sub-genre,<br>
								or you can search by yourself by clicking on the Search button on the top.</font>

                                <div id="td_search">
                                    <table cellspacing="25px" cellpadding="35px" class=a style="width: 400px;">
                                        <tr>
                                            <td id="td_Area" >
											   
											   <form method="post" action="MainPage.php">
												<label for="category"><b>Genre</b></label>
												<select name="parent_cat" id="parent_cat" style="width:185px;">
												<option></option>
												
																					
												<?php while($row = $query_parent->fetch_array()): ?>
												<option value="<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></option>
												<?php endwhile; ?>
												</select>
									
											
                                            <TD  id="td_SalesCatID">
											
											    <label><b>Sub-Genre</b></label>
												<select name="sub_cat" id="sub_cat" style="width:185px;"></select>
												
                                            </TD>

                                            <td valign="top" style="padding-top:10px; width: 1000px; height="200">
											
											<input type='submit'  value='select' name ='go' disabled="disabled"  class='button1'/>									
                                            </td>
                                        </tr>
                                    </table>

								</form>
                            <td style="padding-left: 10px;">
                                <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                    <tr>

                                    </tr>
                                </table>
                            </td>
                            <td style="padding-left: 10px; vertical-align: middle;">
                                <table cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
                                    <tr>
                                        <td>
									<?php 											
										random_artist();								
									?>
                                    </td>
                                    <td>
									<?php 
										random_band();
									?>

                                     </td>
                                    </tr>
                                </table>
                            </td>

                            </td>
                        </tr>
                    </table>
                    </td>
			
                    </tr>
                    </table>
                    </td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
</body>
</html>