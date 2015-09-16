
<?php session_start(); ?>
<?php
if( isset($_SESSION["email"]) && $_SESSION["email"] )
    {
        header("Location: index.html");
        exit;
    }
?>
<?php include('datasnap.php'); ?>

<html lang="en">
<head>
<hr>
    <title>Sign Up</title>
</head>

   <style type="text/css">
    #wrapper {
        width:450px;
        margin:0 auto;
        font-family:Verdana, sans-serif;
    }
    legend {
        color:#0481b1;
        font-size:16px;
        padding:0 10px;
        background:#fff;
        -moz-border-radius:4px;
        box-shadow: 0 1px 5px rgba(4, 129, 177, 0.5);
        padding:5px 10px;
        text-transform:uppercase;
        font-family:Helvetica, sans-serif;
        font-weight:bold;
    }
    fieldset {
        border-radius:4px;
        background: #fff; 
        background: -moz-linear-gradient(#fff, #f9fdff);
        background: -o-linear-gradient(#fff, #f9fdff);
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fff), to(#f9fdff)); /
        background: -webkit-linear-gradient(#fff, #f9fdff);
        padding:20px;
        border-color:rgba(4, 129, 177, 0.4);
    }
    input,
    textarea {
        color: #373737;
        background: #fff;
        border: 1px solid #CCCCCC;
        color: #aaa;
        font-size: 14px;
        line-height: 1.2em;
        margin-bottom:15px;

        -moz-border-radius:4px;
        -webkit-border-radius:4px;
        border-radius:4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset, 0 1px 0 rgba(255, 255, 255, 0.2);
    }
    input[type="text"],
    input[type="password"]{
        padding: 8px 6px;
        height: 22px;
        width:280px;
    }
    input[type="text"]:focus,
    input[type="password"]:focus {
        background:#f5fcfe;
        text-indent: 0;
        z-index: 1;
        color: #373737;
        -webkit-transition-duration: 400ms;
        -webkit-transition-property: width, background;
        -webkit-transition-timing-function: ease;
        -moz-transition-duration: 400ms;
        -moz-transition-property: width, background;
        -moz-transition-timing-function: ease;
        -o-transition-duration: 400ms;
        -o-transition-property: width, background;
        -o-transition-timing-function: ease;
        width: 380px;
        
        border-color:#ccc;
        box-shadow:0 0 5px rgba(4, 129, 177, 0.5);
        opacity:0.6;
    }
    input[type="submit"]{
        background: #222;
        border: none;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.3);
        text-transform:uppercase;
        color: #eee;
        cursor: pointer;
        font-size: 15px;
        margin: 5px 0;
        padding: 5px 22px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-border-radius:4px;
        -webkit-box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
        -moz-box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
        box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
    }
    textarea {
        padding:3px;
        width:96%;
        height:100px;
    }
    textarea:focus {
        background:#ebf8fd;
        text-indent: 0;
        z-index: 1;
        color: #373737;
        opacity:0.6;
        box-shadow:0 0 5px rgba(4, 129, 177, 0.5);
        border-color:#ccc;
    }
    .small {
        line-height:14px;
        font-size:12px;
        color:#999898;
        margin-bottom:3px;
    }
</style>
<body>
<br> 
<body >
<!-- style="background-image:url(wallhaven-74011.jpg);" -->
<h1 > SNAP SERVICES </h1>

      <section class="container">  

      
      <div id="wrapper" align="">
      <form action="" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Please enter the following details:</legend>
                
                <div>
                Enter Your E-mail
                <br>
                    <input type="email" name="email" />
                </div>

                <div>
                Password
                <br>
                    <input type="password" name="password" />
                </div>
                <input type="submit" name="submit" value="Send" class="btn btn-default" />
            </fieldset>    
        </form> 
            </div>

<?php
if (isset($_POST['submit'])) {
  $email=$_POST['email'];
    $password = $_POST['password'];

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

        if(!$row){
            echo "<div>";
            echo "No existing user or wrong password.";
            echo "</div>";
        }
        else {
            // *** My PERSONAL preference is to use {} every where, it just makes it easier if you add  
            // code into the condition later
            $loggedIn = true;
            $_SESSION["email"] = $userName;
            $_SESSION['id'] = $row['id'];
           // header("Location: seller.php");
        }
    }

    if ( !$loggedIn )
   {
        echo "<div>";
        echo "You have been logged in as $email!";
        echo "</div>";
        $_SESSION["email"] = $userName;
    }
    
  }
?>

            
  </body>
  </html>