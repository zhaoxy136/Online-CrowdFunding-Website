<?php
include 'connection.php';
include 'function.php';
session_start();
if (isset($_SESSION['loginuser'])) {
  session_destroy();
  echo "<script>location.href='signup.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Signup Page</title>
    
    <link href="css/signupstyle.css" rel='stylesheet' type='text/css'>
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet" type="text/css">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    	.navbar-brand{
        font-size: 1.8em;
      }
      .error{
    		color: red;
    	}

    </style>

  </head>
  <body>

    <div class="navbar-default navbar-fixed-top">
    	<div class = "container">

        <div class ="navbar-header">
            <button class ="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>
            <a class="navbar-brand" href="homepage.php">SpringBoard</a>

        </div>

        <div class="collapse navbar-collapse">

            <ul class ="nav navbar-nav">
                <li class="active"><a href="homepage.php">Home</a></li>
                <li><a href="explore.php">Explore</a></li>
                <li><a href ="fundrequest.php">Start a project</a></li>
            </ul>

		    </div>
      </div>
    </div>

    <?php
    	$signName = $passCode = $confirmCode = "";
    	$signNameErr = $passCodeErr = $confirmCodeErr = "";
    	//if (isset($_POST['signup'])) {
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    		
    		//validate username, only consists of characters and numbers, 5-32
    		if (empty($_POST['signName'])) {
    			$signNameErr = "Name is required";
  			} else {
    			$signName = test_input($_POST['signName']);
    			if (strlen($_POST['signName']) < 6 || strlen($_POST['signName']) > 32) {
    				$signNameErr = "Your Username must contain 6 to 32 characters!";
    			} elseif (preg_match("/\s+/", $signName)) {
    				$signNameErr = "Username can't contain space.";
    			} elseif (!preg_match("/^[A-Za-z][A-Za-z0-9]/", $signName)) {
    				$signNameErr = "Username should starting with a letter.";
    			}
			}

			//validate password
			if (empty($_POST['passCode'])) {
				$passCodeErr = "Password is required";
			}
  			elseif (($_POST['passCode'] == $_POST['confirmCode'])) {
  				$passCode = test_input($_POST['passCode']);
  				$confirmCode = test_input($_POST['confirmCode']);
  				if (strlen($_POST['passCode']) < 6 || strlen($_POST['passCode']) > 16) {
            		$passCodeErr = "Password must contain 6 to 16 characters!";
        		} elseif (preg_match("/[^A-Za-z0-9_]/", $passCode)) {
    				$passCodeErr = "Password contains special characters.";
        		} elseif (!preg_match("/[0-9]+/",$passCode)) {
        			$passCodeErr = "Password Must Contain At Least 1 Number!";
        		} elseif (!preg_match("/[A-Z]+/",$passCode)) {
        			$passCodeErr = "Password Must Contain At Least 1 Uppercase Letter!";
        		} elseif (!preg_match("/[a-z]+/",$passCode)) {
        			$passCodeErr = "Password Must Contain At Least 1 Lowercase Letter!";
        		}
  			} else {
  				$passCodeErr = "Please Check You've Entered Or Confirmed Your Password!";
  			}

  			//check occupied
  			if ($signNameErr == "" && $passCodeErr == "") {
  				$stmt = $conn->prepare("SELECT UID FROM Accounts WHERE UID = ?");
    			$stmt->bind_param("s", $signName);
    			$stmt->execute();
   				$checkExist = $stmt->get_result();
   				if($checkExist->num_rows > 0) {
    				$signNameErr = "This Name has been occupied! Please try another.";
   				} else {
   					//insert into database;
            $hashed_passcode = password_hash($passCode, PASSWORD_BCRYPT);
   					$insertAcc = $conn->prepare("INSERT INTO Accounts(UID, Passcode) VALUES (?,?)");
   					$insertAcc->bind_param("ss", $signName, $hashed_passcode);
   					$insertAcc->execute();
   					$insertUserProf = $conn->prepare("INSERT INTO UserProfiles(UID) VALUES ('$signName')");
   					$insertUserProf->execute();
   					//redirect to homepage as logged in.
   					$_SESSION['loginuser'] = $signName;
   					echo "<script>location.href='homepage.php'</script>";
  				}
  			}

    	}

    ?>
    
      <div class="main">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <div class="lable">
            Username:<br/>
                <input type="text" name="signName" value="<?php echo $signName; ?>">
                <span class="error"><br/><?php echo $signNameErr;?></span><br/>
            </div>

            <div class="lable-2">

            Password:<br/>
                <input type="password" name="passCode">
                <span class="error"><br/><?php echo $passCodeErr;?></span><br/>

            Confirm Your Password:<br/>
                <input type="password" name="confirmCode">
            </div>
                

            <h2 style="color: red;">By creating an account, you agree to our Terms & Conditions</h2>
            <div class="submit">
                <input type="submit" name="signup" value="Sign Up">
            </div>
            <div class="clear"> </div>
        </form>
    </div><!--end-main-->

    <div class="copy-right">
        <p><a href="homepage.php"> Back To Homepage </a></p>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="application/x-javascript">
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); }
    </script>
  </body>
</html>