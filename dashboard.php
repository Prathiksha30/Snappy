<?php
session_start();
include('datasnap.php');
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
    if ($stmt = $conn->prepare("SELECT firstname, secondname, course, semester, mobile, email  FROM `userdetails` ud LEFT JOIN `user` u ON ud.user_id=u.id WHERE ud.user_id = ?")) 
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
    $stmt->bind_result($order_id);
    while ($stmt->fetch()) {
      $rows[] = array('order_id' => $order_id);
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
    while ($stmt->fetch()) {
      $rows = array('gig_id' => $gig_id);
    }
    $stmt->close();
    return $rows;
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
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->bind_result($user_id);
        while ($stmt->fetch()) 
        {
          $rows = array('user_id' => $user_id);
        }
        $stmt->close();
        return $rows;
      }
}

function getSoldDetails($user_id)
{
    global $conn;
    $rows = array();
    if ($stmt = $conn->prepare("SELECT order_id, category_id, status, confirmed, deliverytime,description,price,seller_gigcompleted FROM `order` o LEFT JOIN advertisement a ON o.gig_id = a.gig_id WHERE a.user_id = ? AND o.status= 'pending' "))
     {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($order_id, $category_id, $status, $confirmed,$deliverytime,$description,$price,$seller_gigcompleted);
        while ($stmt->fetch()) 
        {
          $rows[] = array('order_id' => $order_id, 'category_id' =>  $category_id, 'status' => $status, 'confirmed' => $confirmed,'deliverytime' => $deliverytime, 'description' => $description,'price' => $price, 'seller_gigcompleted' => $seller_gigcompleted);
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
    if ($stmt = $conn->prepare("SELECT order_id, status, confirmed, due_date, category_id, description, price, img, deliverytime FROM `order` o LEFT JOIN advertisement a ON o.gig_id = a.gig_id WHERE o.user_id = ? AND o.status = 'pending' "))
     {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($order_id, $status, $confirmed, $due_date, $category_id, $description, $price, $img, $deliverytime);
        while ($stmt->fetch()) 
        {
          $rows[] = array('order_id' => $order_id, 'status' => $status, 'confirmed' => $confirmed, 'due_date' => $due_date, 'category_id' => $category_id, 'description' => $description, 'price' => $price, 'img' => $img, 'deliverytime' => $deliverytime);
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
    $gigid1 = getGigID($order_id)['gig_id'];
    $date = getDeliveryTime($gigid1);
    // echo $sql = "UPDATE `order` SET due_date=".date('Y-m-d', strtotime('+'.$date.' day', time()))." WHERE order_id=?";
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

if (isset($_POST['sellerconfirm'])) 
{
  updatesellerconfirminordertable($_POST['sellerconfirm']);
}

if (isset($_POST['drop_order_id'])) 
{
  echo "request rejected";
}
 
if (isset($_POST['confirm_order_id'])) 
{
  updateconfirminordertable($_POST['confirm_order_id']);
  updateduedateinordertable($_POST['confirm_order_id']);
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

    <title>Creative - Bootstrap Admin Template</title>

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
                                <a href="#"><i class="icon_profile"></i> My Profile</a>
                            </li>
                            <li>
                                <a href="dashboard.php"><i class="icon_mail_alt"></i>Dashboard</a>
                            </li>
                            <li>
                                <a href="seller.php"><i class="icon_clock_alt"></i> Post a Gig</a>
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
      </header>      
      <!--header end-->

      <!--sidebar start-->
      <!-- <aside>
          <div id="sidebar" class="nav-collapse"> -->
              <!-- sidebar menu start-->
              <!-- <ul class="sidebar-menu">                
                  <li class="active">
                      <a class="" href="dashboard.php">
                          
                          <i class="icon_document_alt"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="index.php" class="">
                          <i class="icon_house_alt"></i>
                          <span>Home page</span>
                         
                      </a>
                      <ul class="sub">
                          <li><a class="" href="form_component.html">Form Elements</a></li>                          
                          <li><a class="" href="form_validation.html">Form Validation</a></li>
                      </ul>
                  </li>       
          <li class="sub-menu">
                      <a href="profile.php" class="">
                          <i class="icon_desktop"></i>
                          <span>Profile</span>
                          
                      </a>
                      <ul class="sub">
                          <li><a class="" href="general.html">Elements</a></li>
                          <li><a class="" href="buttons.html">Buttons</a></li>
                          <li><a class="" href="grids.html">Grids</a></li>
                      </ul>
                  </li>
                  <li>
                      <a class="" href="seller.php">
                          <i class="icon_genius"></i>
                          <span>Post a Gig</span>
                      </a>
                  </li> -->
                  <!-- <li>                     
                      <a class="" href="chart-chartjs.html">
                          <i class="icon_piechart"></i>
                          <span>Charts</span>
                          
                      </a>
                                         
                  </li>
                             
                  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="icon_table"></i>
                          <span>Tables</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="basic_table.html">Basic Table</a></li>
                      </ul>
                  </li>
                  
                  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="icon_documents_alt"></i>
                          <span>Pages</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">                          
                          <li><a class="" href="profile.html">Profile</a></li>
                          <li><a class="" href="login.html"><span>Login Page</span></a></li>
                          <li><a class="" href="blank.html">Blank Page</a></li>
                          <li><a class="" href="404.html">404 Error</a></li>
                      </ul>
                  </li>
                  
              </ul> -->
              <!-- sidebar menu end-->
         <!--  </div>
      </aside> -->
      <!--sidebar end-->
      
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">            
              <!--overview start-->
			  <div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
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
                                foreach (getAllCompletedSales($_SESSION['id']) as $completedsales):
                                  $gigid=getGigID($completedsales['order_id']);
                                  $advertisement_details = getAdvertisementDetails($gigid['gig_id']);
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
                                <?php endforeach; ?>
                            </table>
                          </div>
                          <div class="modal-footer">
                              <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                              <button class="btn btn-success" type="button">Save changes</button>
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
                                <?php endforeach; ?>
                            </table>
                          </div>
                          <div class="modal-footer">
                              <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                              <button class="btn btn-success" type="button">Save changes</button>
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
                              <th>Gig category</th>
                              <th>Gig Description</th>
                              <th>Credits</th>



                              <?php
                                foreach (getSoldDetails($_SESSION["id"]) as $Sold):
                                  
                              ?>
                                <tr>
                                  <td><?php 
                                   echo getCategoryName($Sold['category_id']);

                                  ?></td>
                                  <td>
                                      <?php echo $Sold['description']; ?>
                                  </td>
                                  <td>
                                      <?php echo $Sold['price']; ?>
                                  </td>

                                  <td>
                                      <?php 
                                      if ($Sold['confirmed'] == '1' && $Sold['seller_gigcompleted'] == '1' )
                                      {
                                      ?>
                                         <span class="badge bg-important">Waiting for the buyer to acknowledge delivery of service </span>
                                        
                                         <?php }
                                      else
                                      {
                                        if ($Sold['confirmed'] != '0')
                                          {
                                            ?>
                                            <a class="btn btn-success" data-toggle="modal" href="#myModal2">Confirm</a> 
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
                                                          $u_id_array=getUseridInToDomodal($o_id);
                                                          $u_id = $u_id_array['user_id'];
                                                          ?>
                                                          <th>Fisrt Name</th>
                                                          <th>Second Name</th>
                                                          <th>Course</th>
                                                          <th>Semester</th>
                                                          <th>Mobile Number</th>
                                                          <th>Email ID</th>
                                                          <tr>
                                                            <?php $userdetail = getUserdetails($u_id);?>
                                                            <td>
                                                            <?php echo $userdetail[0]['firstname'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['secondname'];?>
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
                                               <a class="btn btn-success" data-toggle="modal" href="#myModal12">Delivered</a>
                                                              <div class="modal fade" id="myModal12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                  <div class="modal-content">
                                                                     <div class="modal-header">
                                                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                  <h4 class="modal-title">Delivered</h4>
                                                                      </div>
                                                                      <div class="modal-body">
                                                                        Do you confirm that you have delivered the service?
                                                                      </div>
                                                                        <div class="modal-footer">
                                                                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                                                         <form method="POST" action="">
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
                                          <a class="btn btn-success" data-toggle="modal" href="#myModal1">Not Confirmed
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
                                                          $u_id_array=getUseridInToDomodal($o_id);
                                                          $u_id = $u_id_array['user_id'];
                                                          ?>
                                                          <th>Fisrt Name</th>
                                                          <th>Second Name</th>
                                                          <th>Course</th>
                                                          <th>Semester</th>
                                                          <th>Mobile Number</th>
                                                          <th>Email ID</th>
                                                          <tr>
                                                            <?php $userdetail = getUserdetails($u_id);?>
                                                            <td>
                                                            <?php echo $userdetail[0]['firstname'];?>
                                                            </td>
                                                            <td>
                                                            <?php echo $userdetail[0]['secondname'];?>
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
                                                      <input type="hidden" name="drop_order_id" value="<?php echo $Sold['order_id']; ?>">
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
                                               }?> -->

                                                  
                                  
                                          
                                              <!-- <a class="btn btn-success" data-toggle="modal" href="#myModal">Confirm</a> -->
                                              
                                              
                                                <!-- </div> -->
                                           <!--  </td> -->
                                          

                                        
                                  </td>

                              
                                 
                                </tr>
                              <?php endforeach; ?>
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
                              <th>Gig Category</th>
                              <th>Gig Desciption</th>
                              <th>Credit</th>
                              <th>Confirm status</th>
                              <th>Delivery Status</th>
                              <?php
                                foreach (getPurchaseDetails($_SESSION['id']) as $purchase):
                              ?>
                                <tr>
                                  <td>
                                  <?php $category_id=$purchase['category_id']; 
                                   echo getCategoryName(category_id);
                                  ?>
                                  </td>
                                  <td><?php echo $purchase['description']; ?></td>
                                  <td>
                                      <?php echo $purchase['price']; ?>
                                  </td>
                                   <td>
                                      <span class="badge bg-success">
                                        <?php 
                                        if ( $purchase['confirmed']=='1' )
                                          echo "Order confirmed";
                                        else
                                          echo "Order confirmation pending";
                                        ?>
                                      </span>
                                  </td>
                                  <td>
                                      <span class="badge bg-important"><?php echo $purchase['status']; ?></span>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
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
