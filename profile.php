<?php
session_start();
include('datasnap.php');

function getUserdetails($user_id)
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT firstname, secondname, course, semester, mobile, email, DOB  FROM `userdetails` ud LEFT JOIN `user` u ON ud.user_id=u.id WHERE ud.user_id = ?")) 
        {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($firstname, $secondname, $course, $semester, $mobile, $email, $DOB);
        while ($stmt->fetch()) {
          $rows[] = array('firstname' => $firstname, 'secondname' => $secondname, 'course' => $course, 'semester' => $semester, 'mobile' => $mobile, 'email' => $email, 'DOB' => $DOB);
        }
        $stmt->close();
        return $rows;
    }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}

function getUserInfo($user_id)
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT firstname, secondname, photoAd ,Credits FROM `userdetails` WHERE user_id = ?"))
        {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($firstname, $secondname, $photoAd, $Credits);
        while ($stmt->fetch()) {
          $rows[] = array('firstname' => $firstname, 'secondname' => $secondname, 'photoAd' => $photoAd,'Credits'=>$Credits);
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

    <title>Profile</title>

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
                              
                            </span>
                            <span class="username">
                            <?php
                                $name = getUserInfo(21);
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
                                <a href="dashboard.php"><i class="icon-dashboard-l"></i>Dashboard</a>
                            </li>
                            <li>
                                <a href="seller.php"><i class="icon-task-l"></i> Post a Gig</a>
                            </li>
                            <!-- <li>
                                <a href="#"><i class="icon_chat_alt"></i> Chats</a>
                            </li> -->
                            <li>
                                <a href="logout.php"><i class="icon-login-l "></i> Log Out</a>
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
      <!-- <aside> -->
         <!--  <div id="sidebar" class="nav-collapse"> -->
              <!-- sidebar menu start-->
              <!-- <ul class="sidebar-menu"> 
                    <li class="active"> -->
                                 
                  <!-- 
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
          <!-- </div>
      </aside> -->
      <!--sidebar end-->
      
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
		  <div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-laptop"></i>Profile</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
						<!-- <li><i class="icon_documents_alt"></i>Pages</li> -->
						<li><i class="fa fa-user-md"></i>Profile</li>
					</ol>
				</div>
			</div>
              <div class="row">
                <!-- profile-widget -->
                <div class="col-lg-12">
                    <div class="profile-widget profile-widget-info">
                          <div class="panel-body">
                            <div class="col-lg-2 col-sm-2">
                              <h4>
                              <?php
                                $name = getUserInfo($_SESSION['id']);
                                echo $name[0]['firstname']." ".$name[0]['secondname'];
                              ?>
                              </h4>               
                              <div class="follow-ava">
                                
                                 <!--  <img src="upload/".<?php$getUserInfo['photoAd']?>.".jpg"profile-widget-avatar.jpg" alt=""> -->
                                <!-- <img src="<?php echo 'GigUploads/'.$row['img']; ?>" alt="<?php echo $row['description']; ?>" height="200" width="400"> -->
                                <img src="<?php echo 'upload/'.$name[0]['photoAd']; ?>" alt="<?php echo "sorry"?>">
                              </div>
                              <h6>Student</h6>
                            </div>
                            <div class="col-lg-4 col-sm-4 follow-info">
                                
                                <h6>
                                    <span><i class="icon_calendar"></i><?php echo date('l jS \of F Y ');?></span>
                                    <!-- <span><i class="icon_calendar"></i><php echo ("h:i:sa"); ?></span> -->
                                    <!-- <span><i class="icon_pin_alt"></i>NY</span> -->
                                </h6>
                            </div>
                                    <span><i class="icon-bell-l"></i><h4><?php echo $name[0]['Credits'];?></h4></span>
                            <div>

                            </div>
                          </div>
                    </div>
                </div>
              </div>
              <!-- page start-->
              <div class="row">
                 <div class="col-lg-12">
                    <section class="panel">
                          <header class="panel-heading tab-bg-info">
                              <ul class="nav nav-tabs">
                                  <!-- <li class="active">
                                      <a data-toggle="tab" href="#recent-activity">
                                          <i class="icon-home"></i>
                                          Daily Activity
                                      </a>
                                  </li> -->
                                  <li>
                                      <a data-toggle="tab" href="#profile">
                                          <i class="icon-user"></i>
                                          Profile
                                      </a>
                                  </li>
                                  <li class="">
                                      <a data-toggle="tab" href="#edit-profile">
                                          <i class="icon-envelope"></i>
                                          Edit Profile
                                      </a>
                                  </li>
                              </ul>
                          </header>
                          <div class="panel-body">
                              <div class="tab-content">
                                  <!-- <div id="recent-activity" class="tab-pane active">
                                      <div class="profile-activity">                                          
                                          <div class="act-time">                                      
                                              <div class="activity-body act-in">
                                                  <span class="arrow"></span>
                                                  <div class="text">
                                                      <a href="#" class="activity-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
                                                      <p class="attribution"><a href="#">Jonatanh Doe</a> at 4:25pm, 30th Octmber 2014</p>
                                                      <p>It is a long established fact that a reader will be distracted layout</p>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="act-time">                                      
                                              <div class="activity-body act-in">
                                                  <span class="arrow"></span>
                                                  <div class="text">
                                                      <a href="#" class="activity-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
                                                      <p class="attribution"><a href="#">Jhon Loves </a> at 5:25am, 30th Octmber 2014</p>
                                                      <p>Knowledge speaks, but wisdom listens.</p>                                                      
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="act-time">                                      
                                              <div class="activity-body act-in">
                                                  <span class="arrow"></span>
                                                  <div class="text">
                                                      <a href="#" class="activity-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
                                                      <p class="attribution"><a href="#">Rose Crack</a> at 5:25am, 30th Octmber 2014</p>
                                                      <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="act-time">                                      
                                              <div class="activity-body act-in">
                                                  <span class="arrow"></span>
                                                  <div class="text">
                                                      <a href="#" class="activity-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
                                                      <p class="attribution"><a href="#">Jimy Smith</a> at 5:25am, 30th Octmber 2014</p>
                                                      <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="act-time">                                      
                                              <div class="activity-body act-in">
                                                  <span class="arrow"></span>
                                                  <div class="text">
                                                      <a href="#" class="activity-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
                                                      <p class="attribution"><a href="#">Maria Willyam</a> at 5:25am, 30th Octmber 2014</p>
                                                      <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="act-time">                                      
                                              <div class="activity-body act-in">
                                                  <span class="arrow"></span>
                                                  <div class="text">
                                                      <a href="#" class="activity-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
                                                      <p class="attribution"><a href="#">Sarah saw</a> at 5:25am, 30th Octmber 2014</p>
                                                      <p>Knowledge speaks, but wisdom listens.</p>                                                      
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="act-time">                                      
                                              <div class="activity-body act-in">
                                                  <span class="arrow"></span>
                                                  <div class="text">
                                                      <a href="#" class="activity-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
                                                      <p class="attribution"><a href="#">Layla night</a> at 5:25am, 30th Octmber 2014</p>
                                                      <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="act-time">                                      
                                              <div class="activity-body act-in">
                                                  <span class="arrow"></span>
                                                  <div class="text">
                                                      <a href="#" class="activity-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
                                                      <p class="attribution"><a href="#">Andriana lee</a> at 5:25am, 30th Octmber 2014</p>
                                                      <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="act-time">                                      
                                              <div class="activity-body act-in">
                                                  <span class="arrow"></span>
                                                  <div class="text">
                                                      <a href="#" class="activity-img"><img class="avatar" src="img/chat-avatar.jpg" alt=""></a>
                                                      <p class="attribution"><a href="#">Maria Willyam</a> at 5:25am, 30th Octmber 2014</p>
                                                      <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
                                                  </div>
                                              </div>
                                          </div>

                                      </div>
                                  </div> --> 
                                  <!-- profile -->
                                  <div id="profile" class="tab-pane active">
                                    <section class="panel">
                                      <!-- <div class="bio-graph-heading">
                                                Hello I’m Jenifer Smith, a leading expert in interactive and creative design specializing in the mobile medium. My graduation from Massey University with a Bachelor of Design majoring in visual communication.
                                      </div> -->
                                      <div class="panel-body bio-graph-info">
                                          <h1>Personal Information</h1>
                                          <div class="row">
                                          <?php $userdetail = getUserdetails($_SESSION['id']);?>
                                              <div class="bio-row">
                                                  <p><span>First Name </span>:<?php echo $userdetail[0]['firstname'];?> </p>
                                              </div>
                                              <div class="bio-row">
                                                  <p><span>Last Name </span>: <?php echo $userdetail[0]['secondname'];?></p>
                                              </div>                                              
                                              <div class="bio-row">
                                                  <p><span>Date of birth </span>: <?php echo $userdetail[0]['DOB'];?></p>
                                              </div>
                                              <div class="bio-row">
                                                  <p><span>Course </span>: <?php echo $userdetail[0]['course'];?></p>
                                              </div>
                                              <div class="bio-row">
                                                  <p><span>Semester</span>: <?php echo $userdetail[0]['semester'];?></p>
                                              </div>
                                              <div class="bio-row">
                                                  <p><span>Email_ID</span>: <?php echo $userdetail[0]['email'];?></p>
                                              </div>
                                              <div class="bio-row">
                                                  <p><span>Mobile Number </span>: <?php echo $userdetail[0]['mobile'];?></p>
                                              </div>
                                              
                                          </div>
                                      </div>
                                    </section>
                                      <section>
                                          <div class="row">                                              
                                          </div>
                                      </section>
                                  </div>
                                  <!-- edit-profile -->
                                  <div id="edit-profile" class="tab-pane">
                                    <section class="panel">                                          
                                          <div class="panel-body bio-graph-info">
                                              <h1> Profile Info</h1>
                                              <form class="form-horizontal" role="form" action="" method="POST">                                                   
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">First Name</label>
                                                      <div class="col-lg-6">
                                                          <input type="text" name="firstname" class="form-control" >
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Last Name</label>
                                                      <div class="col-lg-6">
                                                          <input type="text" name="lastname" class="form-control" >
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Mobile Number</label>
                                                      <div class="col-lg-10">
                                                          <input type="text" name="mobile" id="" class="form-control" maxlength="10" minlength="10">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Course</label>
                                                      <div class="col-lg-6">
                                                          <input type="text" name="course" class="form-control" >
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Semester</label>
                                                      <div class="col-lg-6">
                                                          <input type="text" name="semester" class="form-control" id="b-day" placeholder=" ">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Date of Birth</label>
                                                      <div class="col-lg-6">
                                                          <input type="date" name="DOB" max="2001-12-31" >
                                                      
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-lg-2 control-label">Gender</label>
                                                      <div class="col-lg-6">
                                                          <input type="radio" name="sex" value ="male" checked>Male
                                                          <input type="radio" name="sex" value ="female">Female
                                                      </div>
                                                  </div>
                                                  <!-- <div class="form-group">
                                                      <label class="col-lg-2 control-label">Email</label>
                                                      <div class="col-lg-6">
                                                          <input type="text" class="form-control" id="email" placeholder=" ">
                                                      </div>
                                                  </div> -->
                                                  
                                                  <!-- <div class="form-group">
                                                      <label class="col-lg-2 control-label">Website URL</label>
                                                      <div class="col-lg-6">
                                                          <input type="text" class="form-control" id="url" placeholder="http://www.demowebsite.com ">
                                                      </div>
                                                  </div> -->

                                                  <div class="form-group">
                                                      <div class="col-lg-offset-2 col-lg-10">
                                                      <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                                          <!-- <button type="submit" name="submit" class="btn btn-primary">Save</button> -->
                                                          
                                                      </div>
                                                  </div>
                                              </form>
                                          </div>
                                      </section>
                                  </div>
                              </div>
                          </div>
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
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- jquery knob -->
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>

  <script>

      //knob
      $(".knob").knob();

  </script>


  </body>
</html>
<?php

 if(isset($_POST['submit']))
 {
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $mobile = $_POST['mobile'];
  $course = $_POST['course'];
  $semester = $_POST['semester'];
  $DOB = $_POST['DOB'];
  $gender = $_POST['sex'];
  $message= "Your personal details have been updated";
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  
                  // echo "hey".$firstname." ".$lastname." ".$mobile." ".$course." ".$semester." ".$DOB." ".$gender."".$_SESSION['id'];
                  global $conn;
                  if ($stmt = $conn->prepare("UPDATE `userdetails` SET `firstname`=?,`secondname`=?,`mobile`=?,`course`=?,`semester`=?,
                    `DOB`=?,`gender`=? WHERE `user_id`=?")) 

                 {
        $stmt->bind_param("ssssissi", $firstname,$lastname,$mobile,$course,$semester,$DOB,$gender,$_SESSION['id']);
        $stmt->execute();
                 }
  header("Location: http://localhost:8080/snappy/profile.php#");
}           