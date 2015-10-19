<?php
session_start();
include('datasnap.php');
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
             
} ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('adminhead.php'); ?>
  </head>

  <body>
  <!-- container section start -->

      

      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
		  <div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-table"></i> Accept or Reject USERS </h3>
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
                         
                          
                          <table class="table table-striped table-advance table-hover">
                           <tbody>
                              <tr>
                                 <th><i class="icon_profile"></i> Full Name</th>
                                 <th><i class="icon_contacts_alt"></i> Id</th>
                                 <th><i class="icon_mail_alt"></i> Email</th> 
                                 <th><i class="icon_calendar"></i> Created At</th>
                                 <th><i class="icon_camera_alt"></i> Photo</th>
                                 <th><i class="icon_tool"></i> Admin Confirm</th>
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

  <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- nicescroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>

</body>
</html>