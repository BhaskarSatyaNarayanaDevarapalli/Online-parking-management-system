<?php 

 
     
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('include/dbconnect.php'); 


     $statement = $db->prepare("UPDATE lot SET status=0 WHERE lotno=?");
     $statement->bind_param('i',$_POST['lotno']);
$statement->execute();

   header("Location:unparkbin.php");
}
?>
