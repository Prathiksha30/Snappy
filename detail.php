<?php include('datasnap.php'); ?>

<?php include('header.html') ?>

<?php

$gig_id = $_GET['gig_id'];
global $conn;
if ($stmt = $conn->prepare("SELECT gig_id, user_id, category_id, description, price, img, deliverytime, created_at, updated_at, language from advertisement WHERE gig_id = ?")) 
{
  $stmt->bind_param('i', $gig_id); // Passing gig_id to select statment
  $result = $stmt->execute();
  $stmt->bind_result($gig_id, $user_id, $category_id, $description, $price, $img, $deliverytime, $created_at, $updated_at, $language); // Fetching results in an array
  while ($stmt->fetch()) {
    $details = array('gig_id' => $gig_id, 'user_id' => $user_id, 'category_id' => $category_id, 'description' => $description, 'price' => $price, 'img' => $img, 'deliverytime' => $deliverytime, 'created_at' => $created_at, 'updated_at' => $updated_at, 'language' => $language); // Creating an array with all the columns 
   
  }
  $stmt->close();
}
else
  echo "error";

function getName($user_id)
{
    global $conn;
    if ($stmt = $conn->prepare("SELECT firstname, secondname FROM userdetails WHERE user_id = ?")) 
        {
        $stmt->bind_param("i", $user_id); //for the select statements
        $stmt->execute();
        $stmt->bind_result($firstname, $secondname);
        while ($stmt->fetch()) {
          $rows[] = array('firstname' => $firstname, 'secondname' => $secondname);
        }
        $stmt->close();
        return $rows;
    }
    else {
            echo "Error";
    }
}

function getEmail($user_id)
{
    global $conn;

    if ($stmt = $conn->prepare("SELECT email FROM `user` WHERE id = $user_id")) 

        {
        //$stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        while ($stmt->fetch()) {
          $rows[] = array('email' => $email);
        }
        $stmt->close();
        return $rows;
    }
    else {
            echo "Error";
    }
}


//NOT WORKING ?
function getCategory($category_id)
{
  global $conn;
  if($stmt = $conn->prepare("SELECT name FROM `category` WHERE category_id = $category_id"))
  {
   // $stmt->bind_param("i", $category_id);  
    $stmt->execute();
    $stmt->bind_result($name);
    while ($stmt->fetch) {
      $row[] = array('name' => $name);
    }
    echo "Name: ".$row[0]['name'];
    $stmt->close();
    return $row;
  }
  else
  {
    echo "Error with category!";
  }
}


?>


<!DOCTYPE html>


<div class="container">
  <div class="row">  
    </div>
    </div>

<h2 class="text-center text-primary"> <?php  $cat = getCategory($category_id);
                                        echo $cat[0]['name']; ?>  </h2>
<hr>
<div class="container">
       <!-- <div class="thumbnail"> <img src="GigUploads/<?php echo $details['img']; ?>" alt="Thumbnail Image 1" height="200" width="400"> -->
        
       <img src="<?php echo 'GigUploads/'.$details['img']; ?>" alt="Thumbnail Image 1" height="200" width="400" align="left">
       

      <strong class="text-primary">Seller Name: <?php $name = getName($user_id);
                              echo $name[0]['firstname']." ".$name[0]['secondname'] ?></strong> <br> <!-- ASK ASHISH WHY [0] is needed -->
      <strong class="text-primary"> Email ID: <?php $name = getEmail($user_id);
                            echo $name[0]['email'];
                                      ?></strong> <br>
      <strong class="text-primary">Description:<?php echo $details['description']; ?></strong> <br>
      <strong class="text-primary">Price:<?php echo $details['price']; ?> </strong> <br>

      
      <form action="" method="POST">
        <input type="hidden" name="gig_id" value="<?php echo $details['gig_id']; ?>">

        <input type="submit" name="confirm" value="Confirm" class="btn btn-default">
      </form>
  
  </div>
</div>
</div>
<hr>
<br>

</body>
</html>

<?php include('footer.html'); ?>