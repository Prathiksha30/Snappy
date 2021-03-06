<?php
session_start();
include('datasnap.php');
//include('head.php');
?>
<!-- php starts here -->
<?php
function getCategoryName($category_id)
{
  global $conn;
  if ($stmt = $conn->prepare("SELECT name FROM `category` WHERE category_id =$category_id")) 
  {
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();
    return $name;
  }
  else {
      printf("Error message: %s\n", $conn->error);
  }
}

function getServicesSoldCount($user_id)
{
    global $conn;
    $sum = 0;
    if ($stmt = $conn->prepare("SELECT gig_id FROM `advertisement` WHERE user_id = ?")) 
    {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($gig_id);
        while ($stmt->fetch()) 
        {
          $adv_gig_ID[] = array('gig_id' => $gig_id);
          if ($stmtt = $conn->prepare("SELECT COUNT(*) FROM `order` WHERE status = 'completed' AND gig_id IN (SELECT gig_id FROM advertisement WHERE user_id= ?)"))
         	{
	          	$stmtt->bind_param("i", $user_id);
	        	$stmtt->execute();
	        	$stmtt->store_result();
	        	$stmtt->bind_result($gig_id2);
	        	while ($result = $stmtt->fetch()) 
	       		 {
	       		 	$sum = $sum + $gig_id2;
	       		 	$rows[] = array('gig_id' => $gig_id2);
	       		 }
        	}
        	else
        	{
        		printf("Error message: %s\n", $conn->error);
        	}
        }

         $stmt->close();
         $stmtt->close();
		 return $rows;
        
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}

function getDeliveryTime($gig_id)
{  
    global $conn;
    if ($stmt = $conn->prepare("SELECT deliverytime FROM `advertisement` WHERE gig_id = ?")) 
    {
        $stmt->bind_param("i", $gig_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($deliverytime);
        $stmt->fetch();
        $stmt->close();
        return $deliverytime;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}

function getServicesPurchasedCount($user_id)
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT COUNT(*) FROM `order` WHERE user_id = ? AND status = 'completed'")) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($value);
        $stmt->fetch();
        $stmt->close();
        return $value;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}
function getUserdetails($user_id)
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT firstname, secondname, course, semester, mobile, email  FROM `user` u LEFT JOIN `userdetails` ud ON ud.user_id=u.id WHERE u.id = ?")) 
        {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($firstname, $secondname, $course, $semester, $mobile, $email);
        while ($stmt->fetch()) {
          $rows[] = array('firstname' => $firstname, 'secondname' => $secondname, 'course' => $course, 'semester' => $semester, 'mobile' => $mobile, 'email' => $email);
        }
        $stmt->close();
        return $rows;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}

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

function getCredits($user_id)
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT Credits FROM `userdetails` WHERE user_id = ?"))
    {
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $stmt->bind_result($Credits);
      while ($stmt->fetch()) {
        $rows[] = array('Credits' => $Credits);
      }
      $stmt->close();
      return $rows;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}

function getAdvertisementDetails($gig_id)
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT category_id, description, price FROM `advertisement` WHERE gig_id = ? ")) 
    {
      $stmt->bind_param("i", $gig_id);
      $stmt->execute();
      $stmt->bind_result($category_id, $description, $price);
      while ($stmt->fetch()) {
        $rows = array('category_id' => $category_id, 'description' => $description, 'price' => $price);
      }
      $stmt->close();
      return $rows;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}

function getAllCompletedSales($user_id)
{
  global $conn;
  if ($stmt = $conn->prepare("SELECT order_id FROM `advertisement` a LEFT JOIN `order` o ON o.gig_id=a.gig_id WHERE a.user_id = ? AND o.status = 'completed'"))
  {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($order_id);
    while ($stmt->fetch()) {
        $rows = array('order_id' => $order_id);
      }
      $stmt->close();
      return $rows;
  }
  else {
    printf("Error message: %s\n", $conn->error);
  }
}
function getGigID($order_id)
{
  global $conn;
  if ($stmt = $conn->prepare("SELECT gig_id FROM `order` WHERE order_id = ? "))
  {
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($gig_id);
    $stmt->fetch();
    $stmt->close();
    return $gig_id;
  }
  else {
    printf("Error message: %s\n", $conn->error);
  }
}

function getAllCompletedPurchases($user_id)
{
  global $conn;
  if ($stmt = $conn->prepare("SELECT gig_id FROM `order` WHERE user_id = ? AND status = 'completed'"))
  {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($gig_id);
    while ($stmt->fetch()) {
      $rows[] = array('gig_id' => $gig_id);
    }
    $stmt->close();
    return $rows;
  }
  else {
    printf("Error message: %s\n", $conn->error);
  }
}

function getAllPendingPurchases($user_id)
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT * FROM `order` WHERE user_id = ? AND status = 'pending'")) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($order_id, $user_id, $gig_id, $status, $confirmed, $created_at, $due_date);
        while ($stmt->fetch()) {
          $rows[] = array('order_id' => $order_id, 'user_id' => $user_id, 'gig_id' => $gig_id, 'status' => $status, 'confirmed' => $confirmed, 'created_at' => $created_at, 'due_date' => $due_date);
        }
        $stmt->close();
        return $rows;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}
function getUseridInToDomodal($order_id)
{
  global $conn;
    $rows = array();
    if ($stmt = $conn->prepare("SELECT user_id FROM `order` WHERE order_id = ?"))
     {
        {
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
    return $user_id;
  }
      }
}

function getSoldDetails($user_id)
{
    global $conn;
    $rows = array();
    if ($stmt = $conn->prepare("SELECT order_id, category_id, status, confirmed, deliverytime ,description,price,seller_gigcompleted, due_date,buyer_gigcompleted FROM `order` o LEFT JOIN advertisement a ON o.gig_id = a.gig_id WHERE a.user_id = ? AND o.status= 'pending' "))
     {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($order_id, $category_id, $status, $confirmed,$deliverytime,$description,$price,$seller_gigcompleted,$due_date,$buyer_gigcompleted);
        while ($stmt->fetch()) 
        {
          $rows[] = array('order_id' => $order_id, 'category_id' =>  $category_id, 'status' => $status, 'confirmed' => $confirmed,'deliverytime' => $deliverytime, 'description' => $description,'price' => $price, 'seller_gigcompleted' => $seller_gigcompleted, 'due_date'=>$due_date,'buyer_gigcompleted'=>$buyer_gigcompleted);
        }
        $stmt->close();
        return $rows;
    }
    else 
    {
        printf("Error message: %s\n", $conn->error);
    }
}


function getPurchaseDetails($user_id)
{
    global $conn;
    $rows = array();
    if ($stmt = $conn->prepare("SELECT order_id,status, confirmed, due_date, category_id, description, price, img, deliverytime,buyer_gigcompleted,seller_gigcompleted FROM `order` o LEFT JOIN advertisement a ON o.gig_id = a.gig_id WHERE o.user_id = ? AND o.status = 'pending' "))
     {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($order_id,$status, $confirmed,$due_date, $category_id, $description, $price, $img, $deliverytime,$buyer_gigcompleted,$seller_gigcompleted);
        while ($stmt->fetch()) 
        {
          $rows[] = array('order_id' => $order_id, 'status' => $status, 'confirmed' => $confirmed,'due_date' => $due_date, 'category_id' => $category_id, 'description' => $description, 'price' => $price, 'img' => $img, 'deliverytime' => $deliverytime, 'buyer_gigcompleted' => $buyer_gigcompleted,'seller_gigcompleted'=>$seller_gigcompleted);
        }
        $stmt->close();
        return $rows;
    }
    else 
    {
        printf("Error message: %s\n", $conn->error);
    }
}

function updateduedateinordertable($order_id)
{
  global $conn;
    $rows = array();
    $gigid1 = getGigID($order_id);
    $date = getDeliveryTime($gigid1);
    if($stmt = $conn->prepare("UPDATE `order` SET due_date='".date('Y-m-d', strtotime('+'.$date.' day', time()))."' WHERE order_id=?"))
    {
      $stmt->bind_param("i", $order_id);
      $stmt->execute();
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function updateconfirminordertable($confirm_order_id)
{
    global $conn;
    $rows = array();
    if($stmt = $conn->prepare("UPDATE `order` SET confirmed='1' WHERE order_id=?"))
    {
      $stmt->bind_param("i", $confirm_order_id);
      $stmt->execute();
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function updatebuyerconfirminordertable($order_id)
{
  global $conn;
    if($stmt = $conn->prepare("UPDATE `order` SET buyer_gigcompleted='1' WHERE order_id=?"))
    {
      $stmt->bind_param("i", $order_id);
      $stmt->execute();
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function updatestatus($order_id)
{
  global $conn;
    if($stmt = $conn->prepare("UPDATE `order` SET status='completed' WHERE order_id=?"))
    {
      $stmt->bind_param("i", $order_id);
      $stmt->execute();
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function updatesellerconfirminordertable($order_id)
{
  global $conn;
    if($stmt = $conn->prepare("UPDATE `order` SET seller_gigcompleted='1' WHERE order_id=?"))
    {
      $stmt->bind_param("i", $order_id);
      $stmt->execute();
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function updaterejectcolumn($order_id)
{
   global $conn;
    if($stmt = $conn->prepare("UPDATE `order` SET rejected='1' WHERE order_id=?"))
    {
      $stmt->bind_param("i", $order_id);
      $stmt->execute();
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function  deleteorderrow($order_id)
{
  global $conn;
    if($stmt = $conn->prepare("DELETE from `order` WHERE order_id=?"))
    {
      $stmt->bind_param("i", $order_id);
      $stmt->execute();
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function getbuyerid($order_id)
{
  global $conn;
    if ($stmt = $conn->prepare("SELECT user_id FROM `order` WHERE order_id=?")) 
    {
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();
        return $user_id;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}
function getusercredit($userid)
{
  global $conn;
    if ($stmt = $conn->prepare("SELECT Credits FROM `userdetails` WHERE user_id=?")) 
    {
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($Credits);
        $stmt->fetch();
        $stmt->close();
        return $Credits;
        echo "Credit".$Credits;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}
function deductcreditfrombuyer($order_id)
{
   global $conn;
   $Adcredit=getAdCredit($order_id);
   $userid=getbuyerid($order_id);
   $usercredits=getusercredit($userid);
   $updatedcredit=$usercredits-$Adcredit;
      if($stmt = $conn->prepare(" UPDATE `userdetails` SET Credits=$updatedcredit WHERE user_id=$userid "))
    {

      $stmt->execute();
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }

}
function getAdCredit($order_id)
{
   global $conn;
    $gigid=getGigID($order_id);
    if($stmt = $conn->prepare("SELECT price from `advertisement` WHERE gig_id=?"))
    {
      $stmt->bind_param("i", $gigid);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($price);
      $stmt->fetch();
      $stmt->close();
      return $price;

    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function updatesellercredit($gig_id)
{
  global $conn;
  $uID=getsellerID($gig_id);
  
  $sellercredit=getusercredit($uID);
  
  $Adcredit=getGigprice($gig_id);
  
  $updatedcredit=$sellercredit+$Adcredit;
  
    if($stmt = $conn->prepare("UPDATE `userdetails` SET Credits=$updatedcredit WHERE user_id=$uID"))
    {
      $stmt->execute();
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function getsellerID($gig_id)
{
   global $conn;
    if($stmt = $conn->prepare("SELECT user_id from `advertisement` WHERE gig_id=?"))
    {
      $stmt->bind_param("i", $gig_id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($user_id);
      $stmt->fetch();
      $stmt->close();
      return $user_id;
      echo "userid".$user_id;
    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
function getGigprice($gig_id)
{
   global $conn;
    if($stmt = $conn->prepare("SELECT price from `advertisement` WHERE gig_id=?"))
    {
      $stmt->bind_param("i", $gig_id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($price);
      $stmt->fetch();
      $stmt->close();
      return $price;
      echo "adcredit".$price;

    }
    else
    {
      printf("Error message: %s\n", $conn->error);
    }
}
if (isset($_POST['delete_order_id']))
{
   deleteorderrow($_POST['delete_order_id']);
}
if (isset($_POST['buyerconfirm']))
{
  updatebuyerconfirminordertable($_POST['buyerconfirm']);
}
if (isset($_POST['sellerconfirm'])) 
{
  updatesellerconfirminordertable($_POST['sellerconfirm']);
}

 
if (isset($_POST['confirm_order_id'])) 
{
  updateduedateinordertable($_POST['confirm_order_id']);
  
  updateconfirminordertable($_POST['confirm_order_id']);
  
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>My Dashboard</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
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
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
  </head>

  <body>
  <?php include_once("analyticstracking.php"); ?>
  <!-- container section start -->
  <section id="container" class="">
      <header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
            </div>

            <!--logo start-->
            <a href="index.php" class="logo">SNAP <span class="lite">SERVICES</span></a>
            <!--logo end-->

            <div class="nav search-row" id="top_menu">
                <!--  search form start -->
                <ul class="nav top-menu">                    
                    <li>
                        <form class="navbar-form">
                            <input class="form-control" placeholder="Search" type="text">
                        </form>
                    </li>                    
                </ul>
                <!--  search form end -->                
            </div>

            <div class="top-nav notification-row">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                                <!-- image goes here -->
                               <!--  <img alt="" src="img/avatar1_small.jpg"> -->
                            </span>
                            <span class="username">
                            <?php
                            	$name = getUserName($_SESSION['id']);
                            	echo $name[0]['firstname']." ".$name[0]['secondname'];
                        	  ?>
                            </span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li class="eborder-top">
                                <a href="profile.php"><i class="icon_profile"></i> My Profile</a>
                            </li>
                            <li>
                                <a href="dashboard.php"><i class="icon_mail_alt"></i>Dashboard</a>
                            </li>
                            <li>
                                <a href="seller.php"><i class="icon_clock_alt"></i> Post a Service</a>
                            </li>
                            <!-- <li>
                                <a href="#"><i class="icon_chat_alt"></i> Chats</a>
                            </li> -->
                            <li>
                                <a href="logout.php"><i class="icon_key_alt"></i> Log Out</a>
                            </li>
                            <!-- <li>
                                <a href="documentation.html"><i class="icon_key_alt"></i> Documents</a>
                            </li> -->
                           <!--  <li>
                                <a href="documentation.html"><i class="icon_key_alt"></i> Documentation</a>
                            </li> -->
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
             <center>
           <div>

    <ul class="nav navbar-nav">
        
        <li><a href="graphics.php">GRAPHICS & DESIGN</a></li>
        <li><a href="Online.php"> ONLINE MARKETING</a></li>
        <li> <a href="writting.php"> WRITING & TRANSLATION </a></li>
        <li> <a href="VideoAudio.php"> VIDEO & AUDIO </a></li>
         <li><a href="Programming.php"> PROGRAMMING & IT</a></li>
         <li><a href="Advertising.php"> ADVERTISING </a></li>
       <!--  <li><a href="Buisness.php"> BUSINESS </a></li>-->
         <li><a href="Academics.php"> ACADEMICS </a></li>
        <li> <a href="#"> OTHERS </a></li> 

    </ul>
    
 </div> </center>
      </header>      
      <!--header end-->
      <section id="main-content">
          <section class="wrapper">            
              <!--overview start-->
			  <div class="row">
				<div class="col-lg-12">
					Up
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.php">Home Page</a></li>
						<li><i class="fa fa-laptop"></i>Dashboard</li>
					</ol>
				</div>
			</div>
              
            <div class="row">
				
                <a data-toggle="modal" href="#myModal4" title="click to view details of gigs sold">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box dark-bg">
                        <i class="fa fa-thumbs-o-up"></i>
                        
                    <div class="count"> <?php $count = getServicesSoldCount($_SESSION['id']); echo $count[0]['gig_id']; ?></div>

                        <div class="title">Sold</div>
                    </div><!--/.info-box-->
                </div><!--/.col-->
                </a>
                <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modaltitleP">Sales details</h4>
                          </div>
                          <div class="modalbodyP">
                            <table>
                                    <th style="padding:5px;"> Gig Category </th>
                                    <th style="padding:5px;"> Gig Descrption </th>
                                    <th style="padding:5px;"> Credit </th>                                
                              <?php
                              if (!is_null(getAllCompletedSales($_SESSION['id']))) {
                                foreach ( getAllCompletedSales($_SESSION['id']) as $compledsales ):
                                  // echo $compledsales;
                                  $gigid=getGigID($compledsales);
                                  $advertisement_details=getAdvertisementDetails($gigid);
                              ?>
                              
                                    <tr>
                                    <td style="padding:5px;">
                                    <?php echo getCategoryName($advertisement_details['category_id']); ?>
                                    </td>                                    
                                    <td style="padding:5px;">
                                    <?php echo $advertisement_details['description']."   " ; ?>
                                    </td>
                                    <td style="padding:5px;">
                                    <?php echo $advertisement_details['price']; ?>
                                    </td>                                                                 
                                    </tr>                                 
                                <?php endforeach; } ?>
                            </table>
                          </div>
                          <div class="modal-footer">
                              <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                              <!-- <button class="btn btn-success" type="button">Save changes</button> -->
                          </div>
                      </div>
                  </div>
              </div>
                <a data-toggle="modal" href="#myModal" title="click to view details of gigs purchased">
        				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        					<div class="info-box brown-bg">
        						<i class="fa fa-shopping-cart"></i>
        						<!-- remove this once the session is available -->
        						<!-- <?php
        						?>-->
        						<!-- remove this once the session is available -->
                    <div class="count"><?php echo getServicesPurchasedCount($_SESSION['id']); ?></div>
        						<div class="title">Purchased</div>
        					</div><!--/.info-box-->
        				</div><!--/.col-->	
                </a>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modaltitleP">Purchase details</h4>
                          </div>
                          <div class="modalbodyP">
                            <table >
                                    <th style="padding:5px;"> Gig Category </th>
                                    <th style="padding:5px;"> Gig Descrption </th>
                                    <th style="padding:5px;"> Credit </th>
                              <?php
                                if (!is_null(getAllCompletedPurchases($_SESSION['id']))) {
                                  foreach (getAllCompletedPurchases($_SESSION['id']) as $completed):
                                    $advertisement_details = getAdvertisementDetails($completed['gig_id']);
                                  ?>
                                      <tr>
                                      <td style="padding:5px;">
                                      <?php echo getCategoryName($advertisement_details['category_id']); ?>
                                      </td>  
                                       <td style="padding:5px;">
                                      <?php echo $advertisement_details['description']."   " ; ?>
                                      </td>
                                      <td>
                                      <?php echo $advertisement_details['price']; ?>
                                      </td style="padding:5px;">
                                      </tr>
                                  <?php endforeach;  } ?> 
                            </table>
                          </div>
                          <div class="modal-footer">
                              <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                              <!-- <button class="btn btn-success" type="button">Save changes</button> -->
                          </div>
                      </div>
                  </div>
              </div>
				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box green-bg">
						<i class="fa fa-cubes"></i>
						<div class="count">
              <?php
                $Credits = getCredits($_SESSION['id']);
                echo $Credits[0]['Credits'];
              ?>
            </div>
						<div class="title">Credits</div>
					</div><!--/.info-box-->
				</div><!--/.col-->
				
			</div><!--/.row-->

              <!-- project team & activity start -->
          <div class="row">

                  <div class="col-lg-6">
                      <!--Project Activity start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                            <div class="row">
                              <div class="col-lg-8 task-progress pull-left">
                                  <h1>To Do </h1>
                              </div>
                            </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                              <th><center>Gig category</center></th>
                              <th><center>Gig Description</center></th>
                              <th><center>Credits</center></th>



                              <?php
                               if (!is_null(getSoldDetails($_SESSION["id"]))) {
                                foreach (getSoldDetails($_SESSION["id"]) as $Sold):
                                  $category_id=$Sold['category_id'];
                              ?>
                                <tr>
                                  <td><?php 
                                   echo getCategoryName($category_id);

                                  ?></td>
                                  <td>
                                      <?php echo $Sold['description']; ?>
                                  </td>
                                  <td>
                                      <?php echo $Sold['price']; ?>
                                  </td>

                                  <td>
                                      <?php
                                      
                                      if($Sold['seller_gigcompleted']=='1' && $Sold['buyer_gigcompleted']=='1')
                                      {
                                      updatestatus($Sold['order_id']);
                                      deductcreditfrombuyer($Sold['order_id']);
                                      $gigid=getGigID($Sold['order_id']);
                                       updatesellercredit($gigid); ?>
                                       <script type="text/javascript">
                                         window.location.href = "dashboard.php";
                                        </script>
                                        <?php
                                      }
                                      if ($Sold['confirmed'] == '1' && $Sold['seller_gigcompleted'] == '1' )
                                      {
                                      ?>
                                         <span class="badge bg-important">Waiting for the buyer to acknowledge delivery of service </span>
                                        
                                         <?php }
                                      
                                      else
                                      {
                                        if ($Sold['confirmed'] != '0' )
                                          {
                                            ?><span class="badge bg-important"><?php echo "due on:".$Sold['due_date'];?></span>

                                            <a class="btn btn-success" data-toggle="modal" href="#myModal2">User Details</a> 
                                              <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                     <div class="modal-header">
                                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                  <h4 class="modal-title">user details</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                         <table>
                                                          <?php
                                                          $o_id=$Sold['order_id'];
                                                          // echo $o_id;
                                                          $u_id=getUseridInToDomodal($o_id);
                                                          
                                                          ?>
                                                          <th><center>Name</center></th>
                                                       <!--    <th>Second Name</th> -->
                                                          <th><center>Course</center></th>
                                                          <th><center>Semester</center></th>
                                                          <th><center>Mobile Number</center></th>
                                                          <th><center>Email ID</center></th>
                                                          <tr>
                                                            <?php $userdetail = getUserdetails($u_id);?>
                                                            <td>
                                                            <?php echo $userdetail[0]['firstname']."".$userdetail[0]['secondname'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['course'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['semester'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['mobile'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['email'];?>
                                                            </td>
                                                          </tr>
                                                    </table>
                                                      </div>
                                                        <div class="modal-footer">
                                                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                                       
                                                       </div>
                                                       </div>
                                                   </div>
                                                   </div>
                                            <?php if ($Sold['seller_gigcompleted'] == '0')
                                               {?>
                                               <a class="btn btn-success" data-toggle="modal" href="#myModal12">Confirm Delivery</a>
                                                              <div class="modal fade" id="myModal12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                  <div class="modal-content">
                                                                     <div class="modal-header">
                                                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                  <h4 class="modal-title">Confirm Delivery</h4>
                                                                      </div>
                                                                      <div class="modal-body">
                                                                        Do you confirm that you have delivered the service?
                                                                      </div>
                                                                        <div class="modal-footer">
                                                                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>  
                                                                        <form  method="POST" action="">
                                                                         <input type="hidden" name="sellerconfirm" value="<?php echo $Sold['order_id']; ?>">
                                                                          <input type="submit" value="Confirm" class="btn btn-success">
                                                                        </form> 
                                                                       </div>
                                                                       </div>
                                                                   </div>
                                                              </div>
                                            <?php } ?>
                                            <?php }


                                           else
                                        {
                                          ?>
                                         <!--  <div class="panel-body"> -->
                                          <a class="btn btn-success" data-toggle="modal" href="#myModal1">Accept to provide service
                                          </a>
                                          <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                 <div class="modal-header">
                                                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                              <h4 class="modal-title">User details</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                        <table>
                                                          <?php
                                                          $o_id=$Sold['order_id'];
                                                          // echo $o_id;
                                                          $u_id=getUseridInToDomodal($o_id);
                                                          
                                                          ?>
                                                          <th><center>Name</center></th>
                                                       <!--    <th>Second Name</th> -->
                                                          <th><center>Course</center></th>
                                                          <th><center>Semester</center></th>
                                                          <th><center>Mobile Number</center></th>
                                                          <th><center>Email ID</center></th>
                                                          <tr>
                                                            <?php $userdetail = getUserdetails($u_id);?>
                                                            <td>
                                                            <?php echo $userdetail[0]['firstname']."".$userdetail[0]['secondname'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['course'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['semester'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['mobile'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['email'];?>
                                                            </td>
                                                          </tr>
                                                    </table>

                                                   </div>
                                                    <div class="modal-footer">
                                                     <button data-dismiss="modal" class="btn btn-default" type="button" style="display:inline;">Close</button>
                                                    <form method="POST" action="" style="display:inline;">
                                                      <input type="hidden" name="delete_order_id" value="<?php echo $Sold['order_id']; ?>">
                                                      <input type="submit" value="Reject" class="btn btn-success">
                                                    </form>
                                                    <form method="POST" action="" style="display:inline;">
                                                      <input type="hidden" name="confirm_order_id" value="<?php echo $Sold['order_id']; ?>">
                                                      <input type="submit" name="Accept" value="Accept" class="btn btn-success">
                                                    </form>
                                                   </div>
                                                   </div>
                                               </div>
                                               </div>
                                           
                                        <?php } ?>

                                      
                                               <!-- else
                                               {
                                                ?>
                                               <span class="badge bg-important">delivered</span>
                                               <?php
                                               }?> 

                                                  
                                  
                                          
                                              <!-- <a class="btn btn-success" data-toggle="modal" href="#myModal">Confirm</a> -->
                                              
                                              
                                                <!-- </div> -->
                                           <!--  </td> -->
                                          

                                        
                                  </td>

                              
                                 
                                </tr>
                              <?php endforeach; 
                              }?>
                              </tbody>
                          </table>

                                      
                                        
                         <!--  <table class="table table-hover personal-task">
                              <tbody>
                              <tr>
                                  <td>Today</td>
                                  <td>
                                      web design
                                  </td>
                                  <td>
                                      <span class="badge bg-important">Upload</span>
                                  </td>
                              </tr>
                              <tr>
                                  <td>Yesterday</td>
                                  <td>
                                      Project Design Task
                                  </td>
                                  <td>
                                      <span class="badge bg-success">Task</span>
                                  </td>
                                  <td>
                                      <div id="work-progress2"></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>21-10-14</td>
                                  <td>
                                      Generate Invoice
                                  </td>
                                  <td>
                                      <span class="badge bg-success">Task</span>
                                  </td>
                                  <td>
                                      <div id="work-progress3"></div>
                                  </td>
                              </tr>                              
                              <tr>
                                  <td>22-10-14</td>
                                  <td>
                                      Project Testing
                                  </td>
                                  <td>
                                      <span class="badge bg-primary">To-Do</span>
                                  </td>
                              </tr>
                              <tr>
                                  <td>24-10-14</td>
                                  <td>
                                      Project Release Date
                                  </td>
                                  <td>
                                      <span class="badge bg-info">Milestone</span>
                                  </td>
                                  <td>
                                      <div id="work-progress4"></div>
                                  </td>
                              </tr>                              
                              <tr>
                                  <td>28-10-14</td>
                                  <td>
                                      Project Release Date
                                  </td>
                                  <td>
                                      <span class="badge bg-primary">To-Do</span>
                                  </td>
                                  <td>
                                      <div id="work-progress5"></div>
                                  </td>
                              </tr>
							  <tr>
                                  <td>Last week</td>
                                  <td>
                                      Project Release Date
                                  </td>
                                  <td>
                                      <span class="badge bg-primary">To-Do</span>
                                  </td>
                                  <td>
                                      <div id="work-progress1"></div>
                                  </td>
                              </tr>
							  <tr>
                                  <td>last month</td>
                                  <td>
                                      Project Release Date
                                  </td>
                                  <td>
                                      <span class="badge bg-success">To-Do</span>
                                  </td>
                              </tr>
                              </tbody>
                          </table> -->
                      </section>
                      <!--Project Activity end-->
                  </div>
                  <div class="col-lg-6">
                      <!--Project Activity start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                            <div class="row">
                              <div class="col-lg-8 task-progress pull-left">
                                  <h1>Services in transit</h1>                                  
                              </div>
                            </div>
                          </div>
                              
                          <table class="table table-hover personal-task">
                              <tbody>
                              <th><center>Gig Category</center></th>
                              <th><center>Gig Desciption</center></th>
                              <th><center>Credit</center></th>
                              <th><center>Confirm status</center></th>
                              

                             <!--  <th>Delivery Status</th> -->
                              <?php
if (!is_null(getPurchaseDetails($_SESSION['id']))) {
                                foreach (getPurchaseDetails($_SESSION['id']) as $purchase):
                              ?>
                                <tr>
                                
                                  <td>
                                  <?php $category_id=$purchase['category_id']; 
                                    echo getCategoryName($category_id);
                                  ?>
                                  </td>
                                  <td><?php echo $purchase['description']; ?></td>
                                  <td>
                                      <?php echo $purchase['price'];
                                      
                                      ?>

                                  </td>
                                   <!-- <td> -->
                                 <?php
                                   if($purchase['seller_gigcompleted'] =='1' && $purchase['buyer_gigcompleted'] =='1')
                                      {
                                       
                                        $gigid=getGigID($purchase['order_id']);
                                        updatesellercredit($gigid);//error here
                                         updatestatus($purchase['order_id']);
                                         deductcreditfrombuyer($purchase['order_id']);?>
                                         <script type="text/javascript">
                                         window.location.href = "dashboard.php";
                                        </script>


                                      <?php 
                                    }
                                  else
                                    { ?><td><?php
                                        if ( $purchase['confirmed']=='1' )
                                        {
                                          
                                           ?><span class="badge bg-important"><?php echo "Order confirmed and is expected by:".$purchase['due_date'];?></span>
                                         <?php 
                                            if ($purchase['buyer_gigcompleted']=='1')
                                           {
                                            ?><span class="badge bg-important"><?php echo "waiting for seller to acknowledge delivery";?></span><?php
                                          }
                                          if ( $purchase['buyer_gigcompleted']=='0')
                                          { ?>

                                            <form  method="POST" action="">
                                            <input type="hidden" name="buyerconfirm" value="<?php echo $purchase['order_id']; ?>">
                                            <input type="submit" value="Confirm Delivery Recieved" class="btn btn-success">
                                            </form> 
                                          <?php
                                          }
                                        }
                                        
                                        else
                                        {
                                         ?><span class="badge bg-important"><?php echo "Order not confirmed";?></span>
                                        <?php
                                        }
                                        
                                   
                                    ?>
                                    </td><?php
                                    }?>
                                    
                                   
                                    
                                   <!-- /td> -->
                                      
                                               <!-- else
                                               {
                                                ?>
                                               <span class="badge bg-important">delivered</span>
                                               <?php
                                               ?> -->

                                                  
                                  
                                          
                                              <!-- <a class="btn btn-success" data-toggle="modal" href="#myModal">Confirm</a> -->
                                              
                                              
                                                <!-- </div> -->
                                           <!--  </td> -->
                                          

                                </tr>
                              <?php endforeach; } ?>
                              </tbody>
                          </table>
                      </section>
                      <!--Project Activity end-->
                  </div>
              </div><br><br>

          </section>
      </section>

      <!--main content end-->
  </section>
  <!-- container section start -->

    <!-- javascripts -->
    <script src="js/jquery.js"></script>
	<script src="js/jquery-ui-1.10.4.min.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- charts scripts -->
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="js/owl.carousel.js" ></script>
	<script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js" ></script>
   
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
	<script src="js/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="js/jquery-jvectormap-world-mill-en.js"></script>
	<script src="js/xcharts.min.js"></script>
	<script src="js/jquery.autosize.min.js"></script>
	<script src="js/jquery.placeholder.min.js"></script>
	<script src="js/gdp-data.js"></script>	
	<script src="js/morris.min.js"></script>
	<script src="js/sparklines.js"></script>	
	<script src="js/charts.js"></script>
	<script src="js/jquery.slimscroll.min.js"></script>
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });
	  
	  /* ---------- Map ---------- */
	$(function(){
	  $('#map').vectorMap({
	    map: 'world_mill_en',
	    series: {
	      regions: [{
	        values: gdpData,
	        scale: ['#000', '#000'],
	        normalizeFunction: 'polynomial'
	      }]
	    },
		backgroundColor: '#eef3f7',
	    onLabelShow: function(e, el, code){
	      el.html(el.html()+' (GDP - '+gdpData[code]+')');
	    }
	  });
	});



  </script>

  </body>
</html>
