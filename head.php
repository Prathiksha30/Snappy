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
 
<!-- 
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet" />    
 -->
<!-- Bootstrap CSS -->    
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
</head>
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
                    <li>
                        <a href="login.php">
                           
                            <?php if (!$_SESSION["email"]) {
                            	
                          ?><span class="username"> START SELLING NOW</span>
                                                     <b class="caret"></b>
                        </a>
                        
                    </li>
                    <!-- user login dropdown end -->
                </ul> 
               <?php } 
                else 
                { ?>  
            
            <!--PROBLEM IS HERE, DROPDOWN MENU IS NOT SHOWN WHEN SESSION IS STARTED! -->

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
                
            	 <?php } ?> <!--end of if-->

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

      </section>
      </html>
