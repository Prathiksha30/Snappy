<?php session_start(); 
function getUserName($user_id)
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
<?php include('datasnap.php');
global $conn; ?>

<!-- For the Recommended Services thing -->

<?php 
global $conn;
if ($stmt = $conn->prepare("SELECT gig_id, user_id, category_id, description, price, img, deliverytime, created_at, updated_at, language from advertisement")) 
{
  //$stmt->bind_param('i', $gig_id); // Passing gig_id to select statment
  $result = $stmt->execute();
  $stmt->bind_result($gig_id, $user_id, $category_id, $description, $price, $img, $deliverytime, $created_at, $updated_at, $language); // Fetching results in an array
  while ($stmt->fetch()) {
    $details[] = array('gig_id' => $gig_id, 'user_id' => $user_id, 'category_id' => $category_id, 'description' => $description, 'price' => $price, 'img' => $img, 'deliverytime' => $deliverytime, 'created_at' => $created_at, 'updated_at' => $updated_at, 'language' => $language); // Creating an array with all the columns 
   
  }
  $stmt->close();
}
else
  echo "error";
?>

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
          
    <!--Search button-->  <form class="navbar-form navbar-left" role="search" method="POST">
        <div class="form-group">
          <input type="text" placeholder= "Search for gigs.." class="form-control" name = "search">
        </div>

        <button type="submit" class="btn btn-default btn-primary" name="Submit">Submit</button>
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

         echo  ' <div class="navbar-form navbar-right">
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


<div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="carousel1" class="carousel slide">
          <ol class="carousel-indicators">
            <li data-target="#carousel1" data-slide-to="0" class="active"> </li>
            <li data-target="#carousel1" data-slide-to="1" class=""> </li>
            <li data-target="#carousel1" data-slide-to="2" class=""> </li>
          </ol>
          <div class="carousel-inner">
            <div class="item"> <img class="img-responsive" src="img/wallhaven-167217.jpg" alt="thumb">
              <div class="carousel-caption"> Snap Services </div>
            </div>
            <div class="item active"> <img class="img-responsive" src="img/wallhaven-74011.jpg" alt="thumb">
              <div class="carousel-caption">  </div>
            </div>
            <div class="item"> <img class="img-responsive" src="img/steam_the_digital_distribution_valve_service_digital_distribution_of_computer_games_95837_1920x1080.jpg" alt="thumb">
              <div class="carousel-caption"> Best service for young students </div>
            </div>
          </div>
          <a class="left carousel-control" href="#carousel1" data-slide="prev"><span class="icon-prev"></span></a> <a class="right carousel-control" href="#carousel1" data-slide="next"><span class="icon-next"></span></a></div>
      </div>
</div>
    <hr>
  </div>
<div class="container">
  <div class="row">  
    </div>
    </div>

<h2 class="text-center text-primary">RECOMMENDED SERVICES</h2>
<hr>
<div class="container">
  <div class="row text-center">
    <?php for ($i=0; $i < 6; $i++) 
    { ?>
      <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
        <div class="thumbnail"> <img src="<?php echo 'GigUploads/'.$details[$i]['img']; ?>" alt="<?php echo $details[$i]['description']; ?>" height="200" width="400">
          <div class="caption">
            <h3><?php echo $details[$i]['description']; ?></h3>
            <!-- Passing the gig_id through the URL. Get the gig_id from the URL in the detail page using $_GET['gig_id'] -->
            <p><a href="detail.php?gig_id=<?php echo $details[$i]['gig_id']; ?>" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Request</a></p>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
    <!-- <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6"> -->
     <!--  <div class="thumbnail"> <img src="img/logo.jpg" alt="Thumbnail Image 1" height="200" width="400">
        <div class="caption">
          <h3>Designing</h3>
          <p>I will design a logo for your website</p>
          <p><a href="#" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to Cart</a></p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
      <div class="thumbnail"> <img src="img/blog.png" alt="Thumbnail Image 1" class="img-responsive" height="200" width="400">
        <div class="caption">
          <h3>&nbsp;</h3>
          <h3>Writing &amp;Translation</h3>
          <p>I will write a blog post about anything</p>
          <p><a href="#" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to Cart</a> </p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
      <div class="thumbnail"> <img src="img/flyer.jpg" alt="Thumbnail Image 1" class="img-responsive" height="200" width="400">
        <div class="caption">
          <h3>Graphic&Designing</h3>
          <p>I will design a flyer for you.</p>
          <p><a href="#" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to Cart</a> </p>
        </div>
      </div>
    </div> -->
   <!--  <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6 hidden-lg hidden-md hidden-sm">
      <div class="thumbnail"> <img src="img/magento.jpeg" alt="Thumbnail Image 1" class="img-responsive" height="200" width="400">
        <div class="caption">
          <h3>Business</h3>
          <p>I will manage your magento based website</p>
          <p><a href="#" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to Cart</a></p>
        </div>
      </div>
    </div>
  </div> -->
  <!-- <div class="row text-center hidden-xs">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="thumbnail"> <img src="img/phpfix.jpg" alt="Thumbnail Image 1" class="img-responsive" height="200" width="400">
        <div class="caption">
          <h3>Programming&IT</h3>
          <p>I will fix all issues related to PHP</p>
          <p><a href="#" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to Cart</a> </p>
        </div>
      </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="thumbnail"> <img src="img/creative.jpg" alt="Thumbnail Image 1" class="img-responsive" height="200" width="400">
        <div class="caption">
          <h3>Writing&Translation</h3>
          <p>I will write an essay in French for you</p>
          <p><a href="#" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to Cart</a> </p>
        </div>
      </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="thumbnail"> <img src="img/phpfix.jpg" alt="Thumbnail Image 1" class="img-responsive" height="200" width="400">
        <div class="caption">
          <h3>Programming & IT</h3>
          <p>I will manage your web page for you.</p>
          <p><a href="#" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to Cart</a> </p>
        </div>
      </div>
    </div>
  </div> -->
  


 
<?php include('footer.html'); ?>

</body>
</html>

<!-- FOR SEARCH BAR -->
<?php
include('datasnap.php');
?>
<?php 
global $conn;
if(isset($_POST['Submit']))
{
    if($_POST['search']!="")
    {
        $search=$_POST['search'];
        if($stmt = $conn-> prepare("SELECT * FROM advertisement WHERE description = '$search' "))
        {
            $stmt->bind_param('s',$search);
            $result = $stmt->execute();
            $stmt->$stmt->bind_result($gig_id, $user_id, $category_id, $description, $price, $img, $deliverytime, $created_at, $updated_at, $language);
            while ($stmt->fetch()) 
            {
            $details = array('gig_id' => $gig_id, 'user_id' => $user_id, 'category_id' => $category_id, 'description' => $description, 'price' => $price, 'img' => $img, 'deliverytime' => $deliverytime, 'created_at' => $created_at, 'updated_at' => $updated_at, 'language' => $language); // Creating an array with all the columns 
            }
            $stmt->close();
        }
        else
        {
            echo "NO RESULTS FOUND!";
        }

    }
}
?>

