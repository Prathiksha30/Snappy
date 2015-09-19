<?php include ("datasnap.php");
?>




<?php session_start(); ?>
<?php
global $conn;
if( isset($_SESSION["email"]) && $_SESSION["email"] )
    {
       session_destroy();
      header("Location: index.php");
       exit;
    }
?>

 
