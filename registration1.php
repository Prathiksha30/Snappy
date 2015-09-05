<?php

include("registerheader.html");
?>
<?php include('datasnap.php'); ?> 

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
                Course
                <br>
                <input type="text" name="course">
                </div>

                <div>
                Semester :
                <br>
                <input type="text" name="semester" >
                </div>

                <div>
                Age:
                <br>
                <input type="date" name="DOB">
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
                    <input type="password" name="password" />
                </div>

                <div>
                Email-ID
                <br>
                    <input type="email" name="email_id" />
                </div> 
                
                <input type="submit" name="submit" value="Send" class="btn btn-default"/>
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
            $course = $_POST['course'];
            $semester = $_POST['semester'];
            $DOB = $_POST['DOB'];
            $gender = $_POST['sex'];
   
            $file = $_FILES["file"]["name"];
            $password = $_POST['password'];
            $email_id = $_POST['email_id'];
                if($stmt =$conn->prepare("INSERT INTO userdetails(firstname,secondname,course,semester,DOB,gender,photoAd) values(?,?,?,?,?,?,?)")) 
                    {
                        $stmt->bind_param('sssssss',$firstname,$lastname,$course,$semester,$DOB,$gender,$file);
                        $result = $stmt->execute();
                        $stmt->close();
                        echo $result;
                     }
                else
                    {
                        echo "error with insertion";
                     }
                      if ($stmtt=$conn->prepare("INSERT INTO user(password,email,created_at) values(?,?,now())"))
                    {
                        $stmtt->bind_param('sss',$password,$email_id);
                        $result = $stmtt->execute();
                        $stmtt->close();
                        echo $result;
                     }
                else
                    {
                        echo "error with insertion";

            
                    }
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
     && ($_FILES["file"]["size"] < 20000)
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
                           "upload/" . $_FILES["file"]["name"]);
                            echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
                            echo $_POST["email_id"];
                        }
                }
       }    
     else 
       {
             echo "Invalid file";
       }

    echo ""; // here pre tag will come in double quotes.
    print_r($_POST);  // show post data
    print_r($_FILES);  // show files data
    die; // die to stop execution. 

?>


</body>
</html>


