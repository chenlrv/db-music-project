<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$q = intval($_GET['q']);

$conn = new mysqli("localhost","root","","music");

$result = $conn->query("SELECT musicSubgenre
FROM musicgenre
where WHERE name = '".$q."'
");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"subgenre":"'  . $rs["musicSubgenre"] . '"}';
   
}
$outp .="]";

$conn->close();

echo($outp);
?>