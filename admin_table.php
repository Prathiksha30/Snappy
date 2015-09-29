<?php
session_start();
include('datasnap.php');
include('head.php');
function getOrderdetails()
{
  global $conn;
    if ($stmt = $conn->prepare("SELECT order_id,user_id,gig_id,status,confirmed,created_at,due_date,seller_gigcompleted,buyer_gigcompleted FROM `order`")) 
    {
     
      $stmt->execute();
      $stmt->bind_result($order_id,$user_id,$gig_id,$status,$confirmed,$created_at,$due_date,$seller_gigcompleted,$buyer_gigcompleted);
      while ($stmt->fetch()) {
        $rows[] = array('order_id'=>$order_id,'user_id'=>$user_id,'gig_id'=>$gig_id,'status'=>$status,'confirmed'=>$confirmed,'created_at'=>$created_at,'due_date'=>$due_date,'seller_gigcompleted'=>$seller_gigcompleted,'buyer_gigcompleted'=>$buyer_gigcompleted);
      }
      $stmt->close();
      return $rows;
          }
    else {
        printf("Error message: %s\n", $conn->error);
    }
    
}
function getGigdetails()
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT gig_id,user_id,category_id, description, price,img,deliverytime,created_at,language FROM `advertisement`")) 
    {
     
      $stmt->execute();
      $stmt->bind_result($gig_id,$user_id,$category_id, $description, $price,$img,$deliverytime,$created_at,$language);
      while ($stmt->fetch()) {
        $rows[] = array('gig_id'=>$gig_id,'user_id'=>$user_id,'category_id'=>$category_id,'description'=>$description,'price'=>$price,'img'=>$img,'deliverytime'=>$deliverytime,'created_at'=>$created_at,'language'=>$language);
      }
      $stmt->close();
      return $rows;
          }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}
function getcategorydetails()
{
  global $conn;
  if ($stmt = $conn->prepare("SELECT category_id,name FROM `category`")) 
  {
    $stmt->execute();
    $stmt->bind_result($category_id,$name);
     while ($stmt->fetch()) 
     {
          $rows[] = array('category_id'=>$category_id,'name' => $name);
        }
    $stmt->close();
    return $rows;
  }
  else {
      printf("Error message: %s\n", $conn->error);
  }
}
function getUserdetails()
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT user_id,firstname, secondname,mobile, course, semester,DOB,gender,photoAd,Credits, email, created_at  FROM `userdetails` ud LEFT JOIN `user` u ON ud.user_id=u.id WHERE u.admin_confirm ='0'")) 
        {
        // $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($user_id,$firstname, $secondname,$mobile, $course, $semester, $DOB,$gender,$photoAd,$Credits, $email, $created_at);
        while ($stmt->fetch()) {
          $rows[] = array('user_id'=>$user_id,'firstname' => $firstname, 'secondname' => $secondname, 'mobile' => $mobile,'course' => $course, 'semester' => $semester, 'DOB'=>$DOB,'gender'=>$gender,'photoAd'=>$photoAd,'Credits'=>$Credits, 'email' => $email,'created_at'=>$created_at);
        }
        $stmt->close();
        return $rows;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
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

    <title>Basic Table | Creative - Bootstrap 3 Responsive Admin Template</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

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
      <!--header start-->
      
      <!--header end-->

      <!--sidebar start-->
      

      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
		  <div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-table"></i> Table</h3>
					<!-- <ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
						<li><i class="fa fa-table"></i>Table</li>
						<li><i class="fa fa-th-list"></i>Basic Table</li>
					</ol> -->
				</div>
			</div>
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              User Table
                          </header>
                          <div class="table-responsive">
                            <table class="table"> 
                            <th>User_ID</th>
                            <th>First Name</th>
                            <th>Second Name</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Course</th>
                            <th>Semester</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>College Id Location</th>
                            <th>Credits</th>
                            <th>Created At</th>
                            <?php 
                            foreach (getUserdetails() as $userdetails):
                                ?>
                                    <tr>
                                    <td style="padding:5px;">
                                    <?php echo $userdetails['user_id']; ?>
                                    </td>                                    
                                    <td style="padding:5px;">
                                    <?php echo $userdetails['firstname']; ?>
                                    </td>
                                    <td style="padding:5px;">
                                    <?php echo $userdetails['secondname']; ?>
                                    </td>
                                    <td style="padding:5px;">
                                    <?php echo $userdetails['email']; ?>
                                    </td>
                                     <td style="padding:5px;">
                                    <?php echo $userdetails['mobile']; ?>
                                    </td>
                                    <td style="padding:5px;">
                                    <?php echo $userdetails['course']; ?>
                                    </td>  
                                    <td style="padding:5px;">
                                    <?php echo $userdetails['semester']; ?>
                                    </td>
                                     <td style="padding:5px;">
                                    <?php echo $userdetails['DOB']; ?>
                                    </td>
                                     <td style="padding:5px;">
                                    <?php echo $userdetails['gender']; ?>
                                    </td>   
                                     <td style="padding:5px;">
                                    <?php echo $userdetails['photoAd']; ?>
                                    </td> 
                                     <td style="padding:5px;">
                                    <?php echo $userdetails['Credits']; ?>
                                    </td> 
                                     <td style="padding:5px;">
                                    <?php echo $userdetails['created_at']; ?>
                                    </td>    
                                    </tr>                                 
                                <?php endforeach; ?>
                            </table>
                          </div>

                      </section>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Category Table
                          </header>
                          <div class="table-responsive">
                            <table class="table"> 
                            <th>Category_ID</th>
                            <th>Category Name</th>
                           
                            <?php 
                            foreach (getcategorydetails() as $categorydetails):
                                ?>
                                    <tr>
                                    <td style="padding:5px;">
                                    <?php echo $categorydetails['category_id']; ?>
                                    </td>                                    
                                    <td style="padding:5px;">
                                    <?php echo $categorydetails['name']; ?>
                                    </td>
                                    </tr>                                 
                                <?php endforeach; ?>
                            </table>
                          </div>

                      </section>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Gig Table
                          </header>
                          <div class="table-responsive">
                            <table class="table"> 
                            <th>Gig_id</th>
                            <th>User_id</th>
                            <th>Category_id</th>
                            <th>Description</th>
                            <th>Credit</th>
                            <th>Image Location</th>
                            <th>Delivery time(in days)</th>
                            <th>Created On</th>
                            <th>Language</th>
                      
                            <?php 
                            foreach (getGigdetails() as $gig):
                                ?>
                                    <tr>
                                    <td style="padding:5px;">
                                    <?php echo $gig['gig_id']; ?>
                                    </td>                                    
                                    <td style="padding:5px;">
                                    <?php echo $gig['user_id']; ?>
                                    </td>
                                    <td style="padding:5px;">
                                    <?php echo $gig['category_id']; ?>
                                    </td>
                                    <td style="padding:5px;">
                                    <?php echo $gig['description']; ?>
                                    </td>
                                     <td style="padding:5px;">
                                    <?php echo $gig['price']; ?>
                                    </td>
                                    <td style="padding:5px;">
                                    <?php echo $gig['img']; ?>
                                    </td>  
                                    <td style="padding:5px;">
                                    <?php echo $gig['deliverytime']; ?>
                                    </td>
                                     <td style="padding:5px;">
                                    <?php echo $gig['created_at']; ?>
                                    </td>
                                     <td style="padding:5px;">
                                    <?php echo $gig['language']; ?>
                                    </td>   
                                     
                                    </tr>                                 
                                <?php endforeach; ?>
                            </table>
                          </div>

                      </section>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Order Table
                          </header>
                          <div class="table-responsive">
                            <table class="table"> 
                            <th>Order_id</th>
                            <th>User_id</th>
                            <th>Gig_id</th>
  
                            <th>Status</th>
                            <th>Confirmed</th>
                            <th>Created On</th>
                            <th>Due_Date</th>
                            <th>Seller Delivery Confirm</th>
                            <th>Buyer Delivery Confirm</th>
                            <?php 
                            foreach (getOrderdetails() as $order):
                                ?>
                                    <tr>
                                    <td style="padding:5px;">
                                    <?php echo $order['order_id']; ?>
                                    </td>                                    
                                    <td style="padding:5px;">
                                    <?php echo $order['user_id']; ?>
                                    </td>
                                    <td style="padding:5px;">
                                    <?php echo $order['gig_id']; ?>
                                    </td>
                                    <td style="padding:5px;">
                                    <?php echo $order['status']; ?>
                                    </td>
                                     <td style="padding:5px;">
                                    <?php echo $order['confirmed']; ?>
                                    </td>                                   
                                    <td style="padding:5px;">
                                    <?php echo $order['created_at']; ?>
                                    </td>  
                                    <td style="padding:5px;">
                                    <?php echo $order['due_date']; ?>
                                    </td>
                                     <td style="padding:5px;">
                                    <?php echo $order['seller_gigcompleted']; ?>
                                    </td>
                                     <td style="padding:5px;">
                                    <?php echo $order['buyer_gigcompleted']; ?>
                                    </td>   
                                     
                                    </tr>                                 
                                <?php endforeach; ?>
                            </table>
                          </div>

                      </section>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Advanced Table
                          </header>
                          
                          <table class="table table-striped table-advance table-hover">
                           <tbody>
                              <tr>
                                 <th><i class="icon_profile"></i> Full Name</th>
                                 <th><i class="icon_calendar"></i> Date</th>
                                 <th><i class="icon_mail_alt"></i> Email</th>
                                 <th><i class="icon_pin_alt"></i> City</th>
                                 <th><i class="icon_mobile"></i> Mobile</th>
                                 <th><i class="icon_cogs"></i> Action</th>
                              </tr>
                              <tr>
                                 <td>Angeline Mcclain</td>
                                 <td>2004-07-06</td>
                                 <td>dale@chief.info</td>
                                 <td>Rosser</td>
                                 <td>176-026-5992</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>
                              <tr>
                                 <td>Sung Carlson</td>
                                 <td>2011-01-10</td>
                                 <td>ione.gisela@high.org</td>
                                 <td>Robert Lee</td>
                                 <td>724-639-4784</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>
                              <tr>
                                 <td>Bryon Osborne</td>
                                 <td>2006-10-29</td>
                                 <td>sol.raleigh@language.edu</td>
                                 <td>York</td>
                                 <td>180-456-0056</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>
                              <tr>
                                 <td>Dalia Marquez</td>
                                 <td>2011-12-15</td>
                                 <td>angeline.frieda@thick.com</td>
                                 <td>Alton</td>
                                 <td>690-601-1922</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>
                              <tr>
                                 <td>Selina Fitzgerald</td>
                                 <td>2003-01-06</td>
                                 <td>moshe.mikel@parcelpart.info</td>
                                 <td>Waelder</td>
                                 <td>922-810-0915</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>
                              <tr>
                                 <td>Abraham Avery</td>
                                 <td>2006-07-14</td>
                                 <td>harvey.jared@pullpump.org</td>
                                 <td>Harker Heights</td>
                                 <td>511-175-7115</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>
                              <tr>
                                 <td>Caren Mcdowell</td>
                                 <td>2002-03-29</td>
                                 <td>valeria@hookhope.org</td>
                                 <td>Blackwell</td>
                                 <td>970-147-5550</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>
                              <tr>
                                 <td>Owen Bingham</td>
                                 <td>2013-04-06</td>
                                 <td>thomas.christopher@firstfish.info</td>
                                 <td>Rule</td>
                                 <td>934-118-6046</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>
                              <tr>
                                 <td>Ahmed Dean</td>
                                 <td>2008-03-19</td>
                                 <td>lakesha.geri.allene@recordred.com</td>
                                 <td>Darrouzett</td>
                                 <td>338-081-8817</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>
                              <tr>
                                 <td>Mario Norris</td>
                                 <td>2010-02-08</td>
                                 <td>mildred@hour.info</td>
                                 <td>Amarillo</td>
                                 <td>945-547-5302</td>
                                 <td>
                                  <div class="btn-group">
                                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                                      <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                                      <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                                  </div>
                                  </td>
                              </tr>                              
                           </tbody>
                        </table>
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
  </section>
  <!-- container section end -->
    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- nicescroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>


  </body>
</html>
