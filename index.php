<?php include('datasnap.php');
include('head.php');
global $conn; ?>
<?php session_start();?>

<!-- For the Recommended Services thing -->
<?php 
global $conn;
if ($stmt = $conn->prepare("SELECT gig_id, user_id, category_id, description, price, img, deliverytime, created_at, language from advertisement")) 
{
  //$stmt->bind_param('i', $gig_id); // Passing gig_id to select statment
  $result = $stmt->execute();
  $stmt->bind_result($gig_id, $user_id, $category_id, $description, $price, $img, $deliverytime, $created_at, $language); // Fetching results in an array
  while ($stmt->fetch()) {
    $details[] = array('gig_id' => $gig_id, 'user_id' => $user_id, 'category_id' => $category_id, 'description' => $description, 'price' => $price, 'img' => $img, 'deliverytime' => $deliverytime, 'created_at' => $created_at, 'language' => $language); // Creating an array with all the columns 
   
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
 <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />    

    <link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="css/widgets.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
</head>
<body>
<?php include_once("analyticstracking.php"); ?>
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
            <div class="item active"> <img class="img-responsive" src="img/snap1.jpg" alt="thumb">
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
<h2 class="text-center text-primary">RECOMMENDED SERVICES</h2>
<hr>

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
<?php include('footer.html'); ?>

</body>
</html>






