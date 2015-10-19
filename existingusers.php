<?php
session_start();
include('datasnap.php');

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
    if ($stmt = $conn->prepare("SELECT user_id,firstname, secondname,mobile, course, semester,DOB,gender,photoAd,Credits, email, created_at  FROM `userdetails` ud LEFT JOIN `user` u ON ud.user_id=u.id WHERE u.admin_confirm ='1'")) 
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
function getUserTable()
{
  global $conn;
  if($stmt = $conn->prepare("SELECT firstname, secondname, photoAd, id, email, created_at, admin_confirm FROM `userdetails` ud LEFT JOIN `user` u ON ud.user_id=u.id "))
  {
    $stmt->execute();
    $stmt->bind_result($firstname, $secondname, $photoAd, $id, $email, $created_at, $admin_confirm);
    while ($stmt->fetch()) {
     $rows[] = array('firstname' => $firstname, 'secondname' => $secondname, 'photoAd' => $photoAd, 'id' => $id , 'email' => $email, 'created_at' => $created_at, 'admin_confirm' => $admin_confirm );
    }
    $stmt->close();
    return $rows;
  }
  else
  {
    printf("Error message: %s\n", $conn->error);
  }
             
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('adminhead.php'); ?>
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
					<h3 class="page-header"><i class="fa fa-table"></i> EXISTING USERS ARE</h3>
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
                          
                          <div class="table-responsive">
                            <table class="table"> 
                            <th><i class="icon_star"></i> User_ID</th>
                            <th><i class="icon_profile"></i> First Name</th>
                            <th><i class="icon_profile"></i> Second Name</th>
                            <th><i class="icon_mail_alt"></i> Email</th>
                            <th><i class="icon_phone"></i> Mobile Number</th>
                            <th><i class="icon_book"></i> Course</th> 
                            <th><i class="icon_document"></i> Semester</th>
                            <th><i class="icon_calendar"></i> DOB</th>
                            <th><i class="icon_ribbon"></i> Gender</th>
                            <th><i class="icon_currency"></i> Credits</th>
                            <th><i class="icon_calendar"></i> Created At</th>
                            <?php 
                            foreach (getUserdetails() as $userdetails):
                                ?>
                                    <tr>
                                    <td style="padding:10px;">
                                    <?php echo $userdetails['user_id']; ?>
                                    </td>                                    
                                    <td style="padding:10px;">
                                    <?php echo $userdetails['firstname']; ?>
                                    </td>
                                    <td style="padding:10px;">
                                    <?php echo $userdetails['secondname']; ?>
                                    </td>
                                    <td style="padding:10px;">
                                    <?php echo $userdetails['email']; ?>
                                    </td>
                                     <td style="padding:10px;">
                                    <?php echo $userdetails['mobile']; ?>
                                    </td>
                                    <td style="padding:10px;">
                                    <?php echo $userdetails['course']; ?>
                                    </td>  
                                    <td style="padding:10px;">
                                    <?php echo $userdetails['semester']; ?>
                                    </td>
                                     <td style="padding:10px;">
                                    <?php echo $userdetails['DOB']; ?>
                                    </td>
                                     <td style="padding:10px;">
                                    <?php echo $userdetails['gender']; ?>
                                    </td>   
                                     
                                     <td style="padding:10px;">
                                    <?php echo $userdetails['Credits']; ?>
                                    </td> 
                                     <td style="padding:10px;">
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
                          
<!-- <br> <br><br> <br><br> <br> -->
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
