<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","root","","dependent_list");

$result = $conn->query("SELECT category_name
FROM categories
");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"category name":"'  . $rs["category_name"] . '"}';
   
}
$outp .="]";

$conn->close();

echo($outp);
?>