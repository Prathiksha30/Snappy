<?php include('datasnap.php'); ?>

<?php
include("head.php");


global $conn;
if ($stmt = $conn->prepare("SELECT gig_id, user_id, category_id, description, price, img, deliverytime, created_at, language from advertisement WHERE category_id = 3")) {
  $result = $stmt->execute();
  $stmt->bind_result($gig_id, $user_id, $category_id, $description, $price, $img, $deliverytime, $created_at, $language);
  while ($stmt->fetch()) {
    $rows[] = array('gig_id' => $gig_id, 'user_id' => $user_id, 'category_id' => $category_id, 'description' => $description, 'price' => $price, 'img' => $img, 'deliverytime' => $deliverytime, 'created_at' => $created_at, 'language' => $language);
  }
  $stmt->close();
}
else
  echo "error";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Writing & Translation</title>
 
<!-- Bootstrap -->

</head>
<body>

 


<div class="container">
  <div class="row">  
    </div>
    </div>

<h2 class="text-center text-primary">Writing and Translation</h2>
<hr>
<div class="container">
  <div class="row text-center">
    <?php foreach ($rows as $row): ?>
      <div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
        <div class="thumbnail"> <img src="<?php echo 'GigUploads/'.$row['img']; ?>" alt="<?php echo $row['description']; ?>" height="200" width="400">
          <div class="caption">
            <h3><?php echo $row['description']; ?></h3>
            <!-- Passing the gig_id through the URL. Get the gig_id from the URL in the detail page using $_GET['gig_id'] -->
            <p><a href="detail.php?gig_id=<?php echo $row['gig_id']; ?>" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Request</a></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
</div>


</body>
</html>
<?php include('footer.html'); ?>