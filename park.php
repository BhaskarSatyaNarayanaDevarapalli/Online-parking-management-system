<?php 

 
     
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('include/dbconnect.php'); 


$statement = $db->prepare("    SELECT lotno FROM lot WHERE email = ? AND vehicleno = ? AND status = 1");
$statement->bind_param('ss',$_POST['email'],$_POST['vehicleno']);
$statement->execute();
$statement->bind_result($returned_lotno);
$statement -> fetch();

//if($statement->num_rows>0) 
header("Location:mycar.php?lot=$returned_lotno");


$sql = <<<SQL
    SELECT *
    FROM `lot`
    WHERE `status` = 0
SQL;

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}


if($row = $result->fetch_assoc())
    $lotno = $row['lotno'];
else {
	//header("Location:nospace.php");
}

     $statement = $db->prepare("UPDATE lot SET vehicleno=? , email=? , status=1 WHERE lotno=?");
     $statement->bind_param('ssi',$_POST['vehicleno'],$_POST['email'],$lotno);
$statement->execute();

/**
	

    $statement = $db->prepare("INSERT into user (vehicleno,email) VALUES (?,?)");
    $statement->bind_param('ss', $_POST['vehicleno'],$_POST['email']);
    $statement->execute();
*/

   header("Location:parkbin.php?lot=$lotno");
}
?>
