<?php session_start(); ?>
<?php
if( isset($_SESSION["email"]) && $_SESSION["email"] )
    {
        header("Location: index.php");
        exit;
    }
?>
<?php

include("head.php");
?>
<?php include('datasnap.php'); global $conn?> 

<html lang="en">
<head>
<hr>
    <title>Adding Admins </title>
</head>
<style type="text/css">
    
</style>
<br> <center>
<body>
    <div id="wrapper">
      <form action="" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Please enter the following details:</legend>
                
                <div>
                <label >First Name</label>
                <br>
                    <input type="text" name="firstname" />
                </div>
<br>
                <div>
                <label >Last Name</label>
                <br>
                    <input type="text" name="lastname" />
                </div>

<br>
                <div>
                <label >Enter Your Phone Number</label>
                <br>
                    <input type="number" name="mobile" />
                </div>

<br>
                <div>
                <label >Gender</label>
                <br>
                <input type="radio" name="sex" value ="male" checked>Male
                <input type="radio" name="sex" value ="female">Female
                </div>
                
                <br>

                <div>
                <label >Password (between 8-10 characters)</label>
                <!--Password-->
                <br>
                    <input type="password" name="password"  />
                </div> 
          <br>
                <div>
                <label >Email-ID</label>
                <br>
                    <input type="email" name="email_id" />
                </div>  <br>
                <div>
             
                <input type="submit" name="submit" value="submit" class="btn btn-default"/>
                </div>
            </fieldset>    
        </form> 
            </div>
            </center>
</body>

<?php include('footer.html') ?>

<script src="js/jquery-1.11.2.min.js"></script> 
<script src="js/bootstrap.min.js"></script>


<?php

            if(isset($_POST['submit']))
                {
                  $firstname = $_POST['firstname'];
                  $lastname = $_POST['lastname'];
                  $mobile = $_POST['mobile'];
                  $gender = $_POST['sex'];
                  $password = $_POST['password'];
                  $email_id = $_POST['email_id'];
            

                  $fields = array('firstname', 'lastname', 'mobile', 'sex', 'password', 'email_id');

                   $error = false; //No errors yet
                  foreach($fields AS $fieldname) 
                    { //Loop trough each field
                      if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname]))
                        {
                           echo "<script type='text/javascript'>alert('field ".$fieldname." not entered , registration unsuccessfull');</script>";
                           //Display error with field
                           
                          $error = true; //Yup there are errors
                        }
                     }

            if(!$error)
            {
              if (strlen ($password)>10 || strlen ($password)<8)
      {
     echo "<font color=red> Password must be between 8 to 10 characters<font>";
       }
   else
        {

            if ($stmtt=$conn->prepare("INSERT INTO user(password, email, created_at) values(?,?,now())")) {
              $stmtt->bind_param('ss', $password, $email_id);
              $result = $stmtt->execute();
              $stmtt->close();
              if ($result) {
                if ($stmt1 = $conn->prepare("SELECT id from user WHERE email = ? LIMIT 1")) {
                  $stmt1->bind_param('s', $email_id);
                  $stmt1->execute();
                  $stmt1->bind_result($id);
                  while ($stmt1->fetch())
                    $row = array('id' => $id);
                  $stmt1->close();
                }
                if($stmt =$conn->prepare("INSERT INTO userdetails(user_id, firstname, secondname, mobile, gender) values(?,?,?,?,?)")) {
                $stmt->bind_param('issss', $row['id'], $firstname, $lastname, $mobile, $gender);
                $result = $stmt->execute();
                $stmt->close();
                //echo $result;
                 }
                else
                  {
                      echo "error with insertion 1";
                   }
                      }
               }
            else
              {
                echo "error with insertion 2";
              }    
              $uid=$row['id'];
              if($S=$conn->prepare("UPDATE `user` SET admin_confirm='1'AND utype='s' WHERE id = $uid "))  
              {
                $S->execute();
                $S->close();
              }
              else
                {
                  printf("Error message: %s\n", $conn->error);
                }   
        }
      }
      }
               
        ?>
        <?php 
        if($result)
        {
          $message = "Succesfully Registered";
                echo "<script type='text/javascript'>alert('$message');</script>";

        }
        ?>





</body>
</html>


