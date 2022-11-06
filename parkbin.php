<?php

require_once('include/dbconnect.php'); 


$sql = <<<SQL
    SELECT *
    FROM `lot`
SQL;

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}


$out='';
while($row = $result->fetch_assoc()){
    echo $row['status'];
    $out=$out.$row['status'];
}


$file = fopen("out.txt","w");
fwrite($file,$out);
fclose($file);

$lot=$_GET['lot'].trim();

header("Location:next.php?lot=$lot");
