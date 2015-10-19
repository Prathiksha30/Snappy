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
    <?php include('head.php'); ?>
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
                              New Users
                          </header>
                          
                          <table class="table table-striped table-advance table-hover">
                           <tbody>
                              <tr>
                                 <th><i class="icon_profile"></i> Full Name</th>
                                 <th><i class="icon_calendar"></i> Id</th>
                                 <th><i class="icon_mail_alt"></i> Email</th>
                                 <th><i class="icon_pin_alt"></i> Created At</th>
                                 <th><i class="icon_pin_alt"></i> Photo</th>
                                 <th><i class="icon_mobile"></i> Admin Confirm</th>
                              </tr>
                           <?php foreach (getUserTable() as $usertab):
                                ?>
                             
                              <?php if($usertab['admin_confirm'] == 0) 
                              {?>
                              <tr>                             
                                    <td>
                                    <?php echo $usertab['firstname']." ".$usertab['secondname']; ?>
                                    </td>                               
                                    <td> <?php echo $usertab['id']; ?> </td>
                              <td> <?php echo $usertab['email']; ?> </td>
                              <td> <?php echo $usertab['created_at']; ?> </td> 
                              <td>  <img src="<?php echo 'GigUploads/'.$usertab['photoAd']; ?>" alt="Photo ID" height="200" width="200" align="center"> </td> 
                                 <td>
                                  <div class="btn-group">
                                      <form method="POST" action="">
                                       <input type="hidden" name="user_id" value="<?php echo $usertab['id']; ?>">
                                      <button type="submit" name="accept" class="btn btn-success"> <i class ="icon_check_alt2"> </i> </button>
                                      
                                      <!-- <button class="btn btn-success" id="accept" ><i class="icon_check_alt2"></i> </button> -->
                                      <button type="submit" class="btn btn-danger" name="reject" value="<?php $usertab['id'] ?>"><i class="icon_close_alt2"></i> </button>
                                      </form>
                                  </div>
                                  </td> <?php }  ?>
                              </tr>                              
                           </tbody>
                        <?php endforeach; ?>
                        </table>
                      </section>
                  </div>
              </div> 
             <!-- FOR ADMIN BUTTONS -->
           <?php  
             if(isset($_POST['accept']))
              {  
                global $conn;
                $uid=$_POST["user_id"];
                if($stmt = $conn->prepare("UPDATE `user` SET admin_confirm='1' WHERE id = $uid "))
                {
                  /*$stmt->bind_param("i", $uid);*/
                  $stmt->execute(); ?>
                  <script type="text/javascript">
                       window.location.href = "admin_table.php";
                  </script>
               <?php }
                else
                {
                  printf("Error message: %s\n", $conn->error);
                }   
              } 
              if(isset($_POST['reject']))
              {  
                global $conn;
                $uid=$_POST["user_id"];
                if($stmt = $conn->prepare("DELETE FROM `userdetails` WHERE user_id = $uid "))
                {
                  /*$stmt->bind_param("i", $uid);*/
                  $stmt->execute();
                } 
                else
                {
                  printf("Error message: %s\n", $conn->error);
                }   
                if($stmt = $conn->prepare("DELETE FROM `user` WHERE id = $uid "))
                {
                  /*$stmt->bind_param("i", $uid);*/
                  $stmt->execute(); ?>
                  <script type="text/javascript">
                       window.location.href = "admin_table.php";
                  </script>
               <?php }
                else
                {
                  printf("Error message: %s\n", $conn->error);
                }   
              }  ?>
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
