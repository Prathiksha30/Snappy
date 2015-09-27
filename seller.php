

<!-- php starts here -->
<?php
include("head.php");
include ("datasnap.php");
if(mysqli_connect_errno()) {
  echo "connection failed:" . mysqli_connect_errno();
  exit();
}
?>

<?php
if(isset($_POST['sub']))
{
  $desc = $_POST['desc'];
  $cat = $_POST['cat'];
  $price = $_POST['price'];
  $lang = $_POST['lang'];
  $delivery= $_POST['days'];
  $Img = $_FILES["file"]["name"];

  
                  $fields = array('desc', 'cat', 'price', 'lang', 'days');

                   $error = false; //No errors yet
                  foreach($fields AS $fieldname) 
                    { //Loop trough each field
                      if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname]))
                        {
                           echo "<script type='text/javascript'>alert('Please fill in all the fields!'); 
                           </script>";
                           //Display error with field
                           
                          $error = true; //Yup there are errors
                        }
                     }

            if(!$error)
            {
//inserts seller details into ad table
    if($stmt = $conn->prepare("INSERT INTO advertisement(user_id, description, price, language, category_id, created_at, img, deliverytime) VALUES(?, ?, ?, ?, ?, now(), ?, ?)"))
    {
      $stmt->bind_param('isisisi', $_SESSION['id'], $desc, $price, $lang, $cat, $Img, $delivery);
      $stmt->execute();
      $stmt->close();
 ?> 
      <!-- ALERT BOX -->
        <script type="text/javascript">
        alert("Gig posted successfully!");
        window.location.href = "dashboard.php";
        </script>
  <?php  }
    else
    {?>
   <script type="text/javascript">
        alert("Error occured. Please try again!");
        window.location.href = "seller.php";
        </script>
   <?php /*echo "Error with insertion";*/
    }
         }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title> Post your Gig</title>
</head>
<body>


<br> <br> <br> <br> <br> 
<div class="container">
  <div class="row">
  <h3 class="font-color" align="center"> Please fill in the form to start Selling! </h6>
    <br><br>
<form method="POST" action="" enctype="multipart/form-data">
  <div class=".form-control:focus">
    <label class="font-color"> I will ... </label>
    <textarea class=".form-control:focus" rows="3" cols="172" name="desc" > </textarea>
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
    <input type="file" name="file" id="file" size="80">
  </div>
  <br> <br>
    <div class=".form-control:focus">
    <label class="font-color">Price:</label>
    <input type="number" class="form-control" name="price">
  </div>
  <br><br>
   <div class=".form-control:focus">
    <label class="font-color">Number of days to deliver the service: (For ex: 3)</label>
    <input type="number" class="form-control" name="days">
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

</body>
</html>

<!-- CODE TO UPLOAD THE FILE -->
 <?php


    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "PNG", "GIF", "JPEG");
    $temp = explode(".", $_FILES["file"]["name"]); //breaking it into 2
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
                if (file_exists("GigUploads/" . $_FILES["file"]["name"])) 
                    {
                        echo $_FILES["file"]["name"] . " already exists. ";
                    } 
                else 
                    {
                        move_uploaded_file($_FILES["file"]["tmp_name"],
                       "GigUploads/" . $Img);
                    }
                }
       }       
    
    
?>
<?php include('footer.html'); ?>