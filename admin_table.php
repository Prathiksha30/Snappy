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
function getcountofnewusers()
{
    global $conn;
    $sum = 0;
    if ($stmt = $conn->prepare("SELECT COUNT(*) FROM `user` WHERE admin_confirm =0")) 
    {
        
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
function getcountofgigs()
{
    global $conn;
    $sum = 0;
    if ($stmt = $conn->prepare("SELECT COUNT(*) FROM `advertisement`")) 
    {
        
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
function getcountofcategories()
{
    global $conn;
    $sum = 0;
    if ($stmt = $conn->prepare("SELECT COUNT(*) FROM `category`")) 
    {
        
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
function getcountoforders()
{
    global $conn;
    $sum = 0;
    if ($stmt = $conn->prepare("SELECT COUNT(*) FROM `order` ")) 
    {
        
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
function getcountofexistingusers()
{
    global $conn;
    $sum = 0;
    if ($stmt = $conn->prepare("SELECT COUNT(*) FROM `user` WHERE admin_confirm =1")) 
    {
        
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
				
			</div>
       <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box lime-bg">
                        <i class="fa fa-table"></i>
                        
                    <div class="count"> <?php echo $count = getcountofnewusers(); ?></div>

                        <div class="title">New Users</div>
                    </div><!--/.info-box-->
          </div>
              
         <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box green-bg">
                        <i class="fa fa-table"></i>
                        
                    <div class="count"> <?php echo $count = getcountofexistingusers(); ?></div>

                        <div class="title">Existing Users</div>
                    </div><!--/.info-box-->
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box teal-bg">
                        <i class="fa fa-table"></i>
                        
                    <div class="count"> <?php echo $count = getcountofcategories(); ?></div>

                        <div class="title">Number of Categories</div>
                    </div><!--/.info-box-->
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box blue-bg">
                        <i class="fa fa-table"></i>
                        
                    <div class="count"> <?php echo $count = getcountofgigs(); ?></div>

                        <div class="title">Number of Gigs posted</div>
                    </div><!--/.info-box-->
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box purple-bg">
                        <i class="fa fa-thumbs-o-up"></i>
                        
                    <div class="count"> <?php echo $count = getcountoforders(); ?></div>

                        <div class="title">Number of Current orders</div>
                    </div><!--/.info-box-->
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
