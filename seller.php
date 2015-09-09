<?php include('datasnap.php'); ?>
<?php session_start(); ?>
<!-- php starts here -->
<?php
include("header.html");

if(isset($_POST['sub']))
{
  $desc = $_POST['desc'];
  $cat = $_POST['cat'];
  $price = $_POST['price'];
  $lang = $_POST['lang'];
  $Img = $_FILES["file"]["name"];
  echo $Img;


//inserts seller details into ad table
  if($stmt = $conn->prepare("INSERT INTO advertisement(user_id, description, price, language, category_id, created_at, updated_at, img) VALUES(?, ?, ?, ?, ?, now(), now(), ?)"))
  {
    $stmt->bind_param('isisis', $_SESSION['id'], $desc, $price, $lang, $cat, $Img);
    $stmt->execute();
    $stmt->close();
  }
  else
  {
    echo "Error with insertion";
  }
}
?>

<br>
<hr>
<div class="container">
  <div class="row">
  <h3 class="font-color" align="center"> Please fill in the form to start Selling! </h6>
    <br><br>
<form method="POST" action="" enctype="multipart/form-data">
  <div class=".form-control:focus">
    <label class="font-color"> I will ... </label>
    <textarea class=".form-control" rows="3" cols="172" name="desc"> </textarea>
    <!--<input type="text" class="form-control" inamed="uname"> -->
    </div>
    <br> <br>
    <div class=".form-control:focus">
   <center> <label class="font-color">Pick a category:</label>
    <select name="cat" class="font-color">
  <option value="1">Graphic Design</option>
  <option value="2">Online Marketing</option>
  <option value="3">Writing & Translation</option>
  <option value="4">Video & Audio</option>
  <option value="5">Programming & IT</option>
  <option value="6">Advertising</option>
  <option value="7">Business</option>
  <option value="8">Academics</option>
  <option value="9">Others</option>
</select> </center>
  </div>
  <br> <br>
   <div class=".form-control:focus">
    <label class="font-color">Add your image here:</label>
     <input type="file" name="file" id="file" class="form-control" size="80">
  </div>
  <br> <br>
    <div class=".form-control:focus">
    <label class="font-color">Price:</label>
    <input type="number" class="form-control" name="price">
  </div>
  <br><br>
  <div class="form-control:focus">
    <label class="font-color">Language:</label>
    <input type="text" class="form-control" name="lang">
  </div> <br>
 <!-- <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div> -->
  <center> <!--<button type="submit" class="btn btn-default" id="submit">Submit</button>-->
  <br>
  <input type="submit" name="sub" value="Submit" class="btn btn-default">
</center>
</form>
<br> <br> <hr>
</div>
</div>

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
</body>
</html>

<!-- CODE TO UPLOAD THE FILE -->
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


                if (file_exists("GigUploads/" . $_FILES["file"]["name"])) 
                    {
                        echo $_FILES["file"]["name"] . " already exists. ";
                    } 
                else 
                    {
                        move_uploaded_file($_FILES["file"]["tmp_name"],
                       "upload/" . $Img);
                        echo "Stored in: " . "GigUploads/" . $_FILES["file"]["name"];
                    }
                }
       }    
     else 
       {
             echo "Invalid file";
       }

    echo ""; // here pre tag will come in double quotes.
    //print_r($_POST);  // show post data
    //print_r($_FILES);  // show files data
    die; // die to stop execution. 

?>