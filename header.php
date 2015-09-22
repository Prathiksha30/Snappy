<?php session_start(); ?>
<?php include("datasnap.php") ?>
<?php function getUserName($user_id)
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT firstname, secondname FROM `userdetails` WHERE user_id = ?")) 
        {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($firstname, $secondname);
        while ($stmt->fetch()) {
          $rows[] = array('firstname' => $firstname, 'secondname' => $secondname);
        }
        $stmt->close();
        return $rows;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}
?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Snap Services</title>
 
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

</head>
<body>
<nav>
  <div class="containerheader"> 
    
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="index.php">Snap Services</a></div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    
          <div class="navbar-text pull-right">
          <a href="#"> <IMG class="flaticon" src="img/savings5.png"> </a><!-- cart -->
          </div>
          
    <!--Search button-->  <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default btn-primary">Submit</button>
      </form>
       <?php
    if(!$_SESSION["email"]) {
      echo '<div class="navbar-form navbar-right" >
        <a href="login.php">
           <button type="submit" class="btn-default btn btn-primary">Sign In</button>
           </a>
           </div>
      <div class="navbar-form navbar-right">
        <a href="registration.php">
           <button type="submit" class="btn-default btn btn-primary">Register</button>
           </a>
           </div>';
         
        }
        else
        {

        $name = getUserName($_SESSION['id']);
        echo "hello there, ".$name[0]['firstname']." ".$name[0]['secondname'];
          echo '<div class="navbar-form navbar-right">
        <a href="seller.php">

           <button type="submit" class="btn-default btn btn-primary">Start Selling</button>
           </a>
           
           </div>
          <div class="navbar-form navbar-right">
        <a href="logout.php">

           <button type="submit" class="btn-default btn btn-primary">Log Out</button>
           </a>
           
           </div>';
         }
    ?>
                 
     
    </div>
    <!-- /.navbar-collapse --> 
 
  <!-- /.container-fluid --> 
</nav>
<div class="container">
		<ul class="nav navbar-nav">
        <li class="active"><a href="#"><span class="sr-only">(current)</span></a></li>
        <li><a href="graphics.php">Graphics & Design</a></li>
        <li><a href="Online.php"> Online Marketing</a></li>
        <li> <a href="writting.php"> Writing & Translation </a></li>
        <li> <a href="VideoAudio.php"> Video & Audio </a></li>
         <li><a href="Programming.php"> Programming & IT</a></li>
         <li><a href="Advertising.php"> Advertising </a></li>
         <li><a href="Buisness.php"> Buisness </a></li>
         <li><a href="Academics.php"> Academics </a></li>
        <li> <a href="#"> Others </a></li> 
    </ul>
 </div>
</body>
</html>
