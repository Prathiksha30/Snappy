<?php include('datasnap.php'); ?>

<?php

$gig_id = $_GET['gig_id'];

global $conn;
if ($stmt = $conn->prepare("SELECT gig_id, user_id, category_id, description, price, img, deliverytime, created_at, updated_at, language from advertisement WHERE category_id = ?")) 
{
  $stmt->bind_param('i', $gig_id); // Passing gig_id to select statment
  $result = $stmt->execute();
  $stmt->bind_result($gig_id, $user_id, $category_id, $description, $price, $img, $deliverytime, $created_at, $updated_at, $language); // Fetching results in an array
  while ($stmt->fetch()) {
    $details = array('gig_id' => $gig_id, 'user_id' => $user_id, 'category_id' => $category_id, 'description' => $description, 'price' => $price, 'img' => $img, 'deliverytime' => $deliverytime, 'created_at' => $created_at, 'updated_at' => $updated_at, 'language' => $language); // Creating an array with all the columns 
  }
  $stmt->close();
}
else
  echo "error";
?>

<!--<?php 
     if( $statment=$conn->prepare("SELECT  firstname, secondname, course from userdeatils WHERE user_id = ?"))
     {
      $res=$statment->execute();
      $statment->bind_result($firstname, $secondname, $course);
      while ($statment->fetch()) {
        $userdetails= array('firstname' => $firstname, 'secondname' => $secondname );
      }
      $statment->close();
     }
     print_r($userdetails);

?> -->


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Snap Services</title>
 
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav>
  <div class="container"> 
    
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="#">Snap Services</a></div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    
          <div class="navbar-text pull-right">
          <a href="#"><i class="fa fa-cart-arrow-down fa-2x"></i></a> <!-- cart -->
          </div>
          
    <!--Search button-->  <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default btn-primary">Submit</button>
      </form>
      <div class="navbar-form navbar-right" >
        <a href="login.php">
           <button type="submit" class="btn-default btn btn-primary">Sign In</button>
           </a>
           </div>
			<div class="navbar-form navbar-right">
        <a href="registration.php">
           <button type="submit" class="btn-default btn btn-primary">Register</button>
           </a>
           </div>
           <div class="navbar-form navbar-right">
        <a href="logout.php">
           <button type="submit" class="btn-default btn btn-primary">Log Out</button>
           </a>
           
           </div>
     
    </div>
    <!-- /.navbar-collapse --> 
 
  <!-- /.container-fluid --> 
</nav>
<div class="container">
		<ul class="nav navbar-nav">
        <li class="active"><a href="#"><span class="sr-only">(current)</span></a></li>
        <li><a href="#">Graphics & Design</a></li>
        <li><a href="#"> Online Marketing</a></li>
        <li> <a href="#"> Writing & Translation </a></li>
        <li> <a href="#"> Video & Audio </a></li>
         <li><a href="#"> Programming & Tech</a></li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Subjects <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#"> Mathematics </a></li>
            <li><a href="#"> Computer Science </a> </li>
            <li><a href="#"> Chemistry </a> </li>
            <li><a href="#"> Phsyics </a> </li>
            <li><a href="#"> Biology </a> </li>
          </ul>     
          <li><a href="#"> Others</a></li>
</li> </ul> </div>

<div class="container">
  <div class="row">  
    </div>
    </div>

<h2 class="text-center text-primary">Graphics</h2>
<hr>
<div class="container">
       <!-- <div class="thumbnail"> <img src="GigUploads/<?php echo $details['img']; ?>" alt="Thumbnail Image 1" height="200" width="400"> -->
        
       <img src="GigUploads/<?php echo $details['img']; ?>" alt="Thumbnail Image 1" height="200" width="400" align="left">
      <strong>Seller Name: <?php echo $details['']; ?></strong>
      <b>Price:<?php echo $details['price']; ?></b> <br>
      <b>Description:<?php echo $details['description']; ?></b>
      <form action="" method="POST">
        <input type="hidden" name="gig_id" value="<?php echo $details['gig_id']; ?>">

        <input type="submit" name="confirm" value="Confirm" class="btn btn-default">
      </form>
  
  </div>
</div>
</div>
<hr>
<br>
<footer class="text-center">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
         <div class="container well">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-7">
        <div class="row">
          <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
            <div>
              <ul class="list-unstyled">
                <li> <a>About Us</a> </li>
                <li> <a>Privacy Policy</a> </li>
                <li> <a>FAQs</a> </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-4  col-xs-6">
            <div>
              
            </div>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
            <div>
              
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-5"> 
        <address>
        <strong>Snap Services</strong><br>
      </address>
       
        </div>
    </div>
  </div>
      </div>
    </div>
  </div>
</footer>
<script src="js/jquery-1.11.2.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>
