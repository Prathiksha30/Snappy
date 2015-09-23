<?php session_start(); ?>
<?php
if( isset($_SESSION["email"]) && $_SESSION["email"] )
    {
        header("Location: index.php");
        exit;
    }
?>
<?php

include("registerheader.html");
?>
<?php include('datasnap.php'); global $conn?> 

<html lang="en">
<head>
<hr>
    <title>Registeration form </title>
</head>
<style type="text/css">
    
</style>
<br> 
<body>
    <div id="wrapper">
      <form action="" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Please enter the following details:</legend>
                
                <div>
                First Name
                <br>
                    <input type="text" name="firstname" />
                </div>

                <div>
                Last Name
                <br>
                    <input type="text" name="lastname" />
                </div>


                <div>
                Enter Your Phone Number
                <br>
                    <input type="text" name="mobile" />
                </div>

                <div>
                Course
                <br>
                <input type="text" name="course">
                </div>

                <div>
                Semester :
                <br>
                <input type="text" name="semester" placeholder="semester" value="">
                </div>

                <div>
                Age:
                <br>
                <input type="date" name="DOB" max="2001-12-31" >
                </div>

                <div>
                Gender
                <br>
                <input type="radio" name="sex" value ="male" checked>Male
                <input type="radio" name="sex" value ="female">Female
                </div>
                <br>

                <div>
                Upload Choice of Identity Verification
                <br>
                <input type="file" name="file" id="file" size="80">

                </div>
                <br>

                <div>
                Password
                <br>
                    <input type="password" name="password" placeholder="password" />
                </div>

                <div>
                Email-ID
                <br>
                    <input type="email" name="email_id" />
                </div> 
                <div>
              <a href="index.php">
                <input type="submit" name="submit" value="Send" class="btn btn-default"/>
                </a>
                </div>
            </fieldset>    
        </form> 
            </div>
</body>

<br> <hr>
<!-- Footer starts here -->
<footer class="text-center">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
         <div class="container well">
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-7">
        <div class="row">
          <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
            <div>
              <ul class="list-unstyled">
                <li> <a>About Us</a> </li>
                <li> <a>Privacy Policy</a> </li>
                <li> <a>FAQs</a> </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-4  col-xs-6">
            <div>
              
            </div>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
            <div>
              
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-5"> 
        <address>
        <strong>Snap Services</strong><br>
        
        <!--<abbr title="Phone">P:</abbr> (123) 456-7890 -->
      </address>
       
        </div>
    </div>
  </div>
      </div>
    </div>
  </div>
</footer>
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
                echo $result;
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
               
        ?>
        <?php 
        if($result)
        {
          $message = "succesfully";
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


