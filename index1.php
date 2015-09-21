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
    $details = array('gig_id' => $gig_id, 'user_id' => $user_id, 'category_id' => $category_id, 'description' => $description, 'price' => $price, 'img' => $img, 'deliverytime' => $deliverytime, 'created_at' => $created_at, 'updated_at' => $updated_at, 'language' => $language); // Creating an array with all the columns 
   
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
<!--analytics-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-67264606-1', 'auto');
  ga('send', 'pageview');

</script>
<!--end of analytics-->
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <div class="header">
<nav>
  <div class="container"> 
    
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="#">Snap Services</a></div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="navbar-text pull-right">
          <a href="#"> <IMG class="flaticon" src="img/savings5.png"> </a><!-- cart -->
          </div>
          
    <!--Search button-->  <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <div class="navbar-form navbar-right" >
           <button type="submit" class="btn-default btn">Sign In</button>
           </div>
			<div class="navbar-form navbar-right">
           <button type="submit" class="btn-default btn">Register</button>
           </div>
     
    </div>
    <!-- /.navbar-collapse --> 
 
  <!-- /.container-fluid --> 
</nav>
</div>
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

<div class="container2">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="carousel1" class="carousel slide">
          <ol class="carousel-indicators">
            <li data-target="#carousel1" data-slide-to="0" class="active"> </li>
            <li data-target="#carousel1" data-slide-to="1" class=""> </li>
            <li data-target="#carousel1" data-slide-to="2" class=""> </li>
          </ol>
          <div class="carousel-inner">
            <div class="item"> <img class="img-responsive" src="img/efsef2.jpg" alt="thumb">
              <div class="carousel-caption" ><font size="22" color="#212121"> Snap Services </font></div>
            </div>
            <div class="item active"> <img class="img-responsive" src="img/snappy2.jpg" alt="thumb">
              <div class="carousel-caption">  </div>
              <div class="carousel-caption"><font size="22" color="#212121"> One step solution </font> </div>
            </div>
            <div class="item"> <img class="img-responsive" src="img/plane2.jpg" alt="thumb">
              <div class="carousel-caption"> <font size="22" color="#212121"> Best service for young students </font></div>
            </div>
          </div>
          <a class="left carousel-control" href="#carousel1" data-slide="prev"><span class="icon-prev"></span></a> <a class="right carousel-control" href="#carousel1" data-slide="next"><span class="icon-next"></span></a></div>
      </div>
</div>
    
  </div>

    
 <div class="sunit4">
  <IMG class="sunit3" src="img/about me.jpg">
</div>



<div class="sunit2">
<hr>
<h2 class="text-center">RECOMMENDED SERVICES</h2>
<hr>
</div>
 <div class="row text-center">
    <?php $i=0;
      
      for ($i=0; $i < 6; $i++) { 
                
      ?>
      <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
        <div class="thumbnail"> <img src="<?php echo 'GigUploads/'.$details[$i]['img']; ?>" alt="<?php echo $details[$i]['description']; ?>" height="200" width="400">
          <div class="caption">
            <h3><?php echo $details['description']; ?></h3>
            <!-- Passing the gig_id through the URL. Get the gig_id from the URL in the detail page using $_GET['gig_id'] -->
            <p><a href="detail.php?gig_id=<?php echo $details['gig_id']; ?>" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Request</a></p>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>


<footer class="sunit">
  <!--<div class="containerwell">-->
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-7">
        <div class="row">
          <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
            <div>
              <ul class="list-unstyled">
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-4  col-xs-6">
            <div>
              <ul class="list-unstyled">
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
            <div>
              <ul class="list-unstyled">
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
                <li> <b>Link anchor</b> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-5">
        <address>
        <strong>Snap, Inc.</strong><br>
Indian Solution Link<br>
Bangalore, WA, 99110-0219<br>
<abbr title="Phone">P:</abbr> (123) 456-7890
        </address>
        <address>
        <strong>Developed by</strong><br>
        Aastha,Navomi,Pratiksha,Sunit<br>
        <strong>Designed by</strong><br>
        Sunit Nitin Ramniclal
        </address>
        <div class="row">
      <div class="col-xs-12">
      </div>
      </div>
    </div>
  </div>
   <p>Copyright © Snap. All rights reserved.</p>
    </div>
</footer>
</div>
<script src="js/jquery-1.11.2.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>
