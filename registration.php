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
    <title>Registeration form </title>
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
                    <input type="text" name="mobile" />
                </div>
<br>
                <div>
                <label > Course</label>
                <br>
                <input type="text" name="course">
                </div>
<br>
                <div>
               <label > Semester :</label>
                <br>
                <input type="number" name="semester" placeholder="Ex: 3" value="">
                </div>
<br>
                <div>
                <label > Age:</label>
                <br>
                <input type="date" name="DOB" max="2001-12-31" >
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
                <label >Upload Choice of Identity Verification</label>
                <br>
                <input type="file" name="file" id="file" size="80">

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
              <a href="index.php">
                <input type="submit" name="submit" value="Submit" class="btn btn-default"/>
                </a>
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
                  $course = $_POST['course'];
                  $semester = $_POST['semester'];
                  $DOB = $_POST['DOB'];
                  $gender = $_POST['sex'];
                 $file = $_FILES["file"]["name"];
                  $password = $_POST['password'];
                  $email_id = $_POST['email_id'];
            

                  $fields = array('firstname', 'lastname', 'mobile', 'course', 'semester', 'DOB', 'sex', 'password', 'email_id');

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

  if (strlen ($password)>10 || strlen ($password)<8)
      {
     echo "<font color=red> Password must be between 8 to 10 characters<font>";
       }
   else
        {

            if(!$error)
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
                if($stmt =$conn->prepare("INSERT INTO userdetails(user_id, firstname, secondname, mobile, course, semester, DOB, gender, photoAd) values(?,?,?,?,?,?,?,?,?)")) {
                $stmt->bind_param('issssssss', $row['id'], $firstname, $lastname, $mobile, $course, $semester, $DOB, $gender, $file);
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

<?php

    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);

     if ((($_FILES["file"]["type"] == "image/gif")
     || ($_FILES["file"]["type"] == "image/jpeg")
     || ($_FILES["file"]["type"] == "image/jpg")
     || ($_FILES["file"]["type"] == "image/pjpeg")
     || ($_FILES["file"]["type"] == "image/x-png")
     || ($_FILES["file"]["type"] == "image/png"))
     && ($_FILES["file"]["size"] < 1000000)
     && in_array($extension, $allowedExts)) 
        {
            if ($_FILES["file"]["error"] > 0) 
                {
                     echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } 
            else 
                {
                 echo "Upload: " . $_FILES["file"]["name"] . "<br>";
                 echo "Type: " . $_FILES["file"]["type"] . "<br>";
                 echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                 echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";


                if (file_exists("upload/" . $_FILES["file"]["name"])) 
                    {
                        echo $_FILES["file"]["name"] . " already exists. ";
                    } 
                else 
                    {
                        move_uploaded_file($_FILES["file"]["tmp_name"],
                       "upload/" . $file);
                        echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
                    }
                }
       }    
     else 
       {
             echo "Invalid file";
       }

    echo "";

               
     // here pre tag will come in double quotes.
    //print_r($_POST);  // show post data
    //print_r($_FILES);  // show files data
    die; // die to stop execution. 

?>



</body>
</html>


