
<?php session_start(); ?>
<?php

if( isset($_SESSION["email"]) && $_SESSION["email"] )
    {
        header("Location: index.php");
        exit;
    }
?>
<?php
include('datasnap.php');
function getUserDeets($emailId)
{
     global $conn;
        if ($stmt = $conn->prepare("SELECT utype, admin_confirm  FROM `user` WHERE email = ? ")) 
        {
            $stmt->bind_param("s",$emailId);
            $stmt->execute();
            $stmt->bind_result($utype, $admin_confirm);
            while ($stmt->fetch())
            {
                $rows = array('utype' => $utype, 'admin_confirm' => $admin_confirm);
            }
        $stmt->close();
        return $rows;
        }
    else {
        printf("Error message: %s\n", $conn->error);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Snap Services- Login</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>




    <body class="login-img3-body">

    <div class="container">
 <form class="login-form" action="" method="POST" enctype="multipart/form-data">        
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="email" class="form-control" placeholder="Email" name="email" autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div>
            
              
            <button class="btn btn-primary btn-lg btn-block" type="submit" name ="submit" value="send">Login</button>
            
            </div>
            <div>
            
                    <a href="registration.php" >
            <button class="btn btn-info btn-lg btn-block" type="button" >Signup  </button>
            </a>
            </div>
      </form>

    </div>
<?php
if (isset($_POST['submit'])) 
{
    $emailId=$_POST['email'];
    getUserDeets($emailId);
    $password = $_POST['password'];   
   
    //VALUE NOT GETTING STORED

    $Usert = $getUserDeets['utype'];
    $aconfirm = $getUserDeets['admin_confirm'];
    /*echo "USER DETAILS".$Usert." ".$aconfirm;
*/
   
 // turn error reporting on, it makes life easier if you make typo in a variable name etc
    error_reporting(E_ALL);
  
     //$queryy = "SELECT firstname FROM userdetails ";// AND password = $userPass";

       // $resultt = mysqli_query( $conn, $queryy);
       // $roww = mysqli_fetch_array($resultt);
  /*  if( isset($_SESSION["email"]) && $_SESSION["email"] )
    {
        echo "You are already logged in, ".$_SESSION['email']."! <br> I'm Loggin you out M.R ..";
        unset( $_SESSION );
        session_destroy();

        // *** The empty quotes do nothing
        // exit("");
        exit;
    }*/

    $loggedIn = false;

    // *** While or is nice solution, it doesn't take into account when the 'name' index is not set, which generates a php warning
    // $userName = $_POST["name"] or "";
    $userName = isset($_POST["email"]) ? $_POST["email"] : null;

    // *** same change as above
    // $userPass = $_POST["pass"] or "";
    $userPass = isset($_POST["password"]) ? $_POST["password"] : null;

    // *** This test really comes down to, what if username or password is evaluated to false.
    // have a good think about what it is you are actually testing
    // php casts strings and numeric values to boolean, so something that you don't think is false could be cast as false, eg a string containing "0"
    if ($userName && $userPass )
    {
        // User Entered fields
      
        $query = "SELECT id FROM user WHERE email = '$userName' AND password = '$userPass'";// AND password = $userPass";
        
        $result = mysqli_query( $conn, $query);

        // *** Error checking, what if !$result? eg query is broken

        $row = mysqli_fetch_array($result);
        if (!$row) {
            echo "<div>";
            $message= "No existing user or wrong password.";
            
            echo "<script type='text/javascript'>alert('$message');</script>";
         
            echo "</div>";
        }
        else {
            // *** My PERSONAL preference is to use {} every where, it just makes it easier if you add  
            // code into the condition later
           if( $loggedIn = true)
                
                if($Usert == 's' && $aconfirm == '1') //checks if user is student + admin has confirmed
                 {       
                    $_SESSION["email"] = $userName;
                    $_SESSION['id'] = $row['id'];
                    header("Location: dashboard.php");
                 }
                        else
                            {
                                echo "<div>";
                                $message= "Please wait for the admin to confirm your college ID. Try again after 2 hours";
            
                                 echo "<script type='text/javascript'>alert('$message');</script>";
         
                                 echo "</div>";
                            }

                    }
                //else
                  //  {
                    //    $_SESSION["email"] = $userName;
                      //  $_SESSION['id'] = $row['id'];
                        //header("Location: admin_table.php");
                    //}

          
            }


    }

    
  
?>

            
  </body>
  </html>