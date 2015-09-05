

<!-- php starts here -->
<?php
include("header.html");

$conn= new mysqli("localhost","root","","snapservices");
if(mysqli_connect_error())
{
  echo "Error in database connection";
  exit();
}

if(isset($_POST['sub']))
{
  $desc = $_POST['desc'];
  $cat = $_POST['cat'];
  $price = $_POST['price'];
  $lang = $_POST['lang'];
  //echo "$desc";



//inserts seller details into ad table
  if($stmt = $conn->prepare("INSERT INTO advertisement(description, price, language,category_id,created_at,updated_at) VALUES(?,?,?,?,now(),now())"))
  {
    $stmt->bind_param('sisi', $desc, $price, $lang,$cat);
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
<form method="POST" action="">
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
    <input type="file" class="form-control" name="image">
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

