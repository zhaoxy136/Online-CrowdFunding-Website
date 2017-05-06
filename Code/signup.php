<?php
session_start();
include 'connection.php';
include 'function.php';
?>


<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sign Up</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/signupstyle.css" rel='stylesheet' type='text/css' />


    <style type="text/css">
    	div.middlebody{
    		background-color: lightblue;

    		width: 400px;
    		height: 200px;
    		position: relative;
    		top: 250px;
    		text-align: center;

            margin:auto;
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
            <a class="navbar-brand">Spring Board</a>

        </div>

        <div class="collapse navbar-collapse">

            <ul class ="nav navbar-nav">
                <li><a href="homepage.php">Home</a></li>
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
            		$passCodeErr = "Your Password must contain 6 to 16 characters!";
        		} elseif (preg_match("/[^A-Za-z0-9_]/", $passCode)) {
    				$passCodeErr = "Your password contains special characters.";
        		} elseif (!preg_match("/[0-9]+/",$passCode)) {
        			$passCodeErr = "Your Password Must Contain At Least 1 Number!";
        		} elseif (!preg_match("/[A-Z]+/",$passCode)) {
        			$passCodeErr = "Your Password Must Contain At Least 1 Uppercase Letter!";
        		} elseif (!preg_match("/[a-z]+/",$passCode)) {
        			$passCodeErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
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
   					$insertAcc = $conn->prepare("INSERT INTO Accounts(UID, Passcode) VALUES (?,?)");
   					$insertAcc->bind_param("ss", $signName, $passCode);
   					$insertAcc->execute();
   					$insertUserProf = $conn->prepare("INSERT INTO UserProfiles(UID, FirstName, LastName, 
   						Gender, City, State, Cellphone, EmailAddress, CreditCardNumber, Interests) VALUES ('$signName', null, null, null, null, null, null, null, null, null)");
   					$insertUserProf->execute();
   					//redirect to homepage as logged in.
   					session_start();
   					$_SESSION['user'] = $signName;
   					echo "<script>location.href='HomePage.php'</script>";
  				}
  			}

    	}

    ?>

    <div class="main">
        <!-----start-main---->




        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <div class="lable">
                Username:<br/>
                <input type="text" name="signName" value="<?php echo $signName; ?>">
                <span class="error"><br/><?php echo $signNameErr;?></span><br/>

            </div>
            <div class="clear"> </div>

            <div class="lable-2">
            Password:<br/>
            <input type="password" name="passCode"><span class="error"><br/><?php echo $passCodeErr;?></span>
            <br/>
                <div class="clear"></div>

            Confirm Your Password:<br/>
            <input type="password" name="confirmCode">

            </div>
            <div class="clear"></div>



            <h3>By creating an account, you agree to our Terms & Conditions</h3>
            <div class="submit">
                <input type="submit" name="signup" value="Sign Up">
            </div>
            <div class="clear"> </div>




        </form>


        <!-----//end-main---->
    </div>



    <!-----start-copyright---->
    <div class="copy-right">
        <p><a href="homepage.php"> Back To Homepage </a></p>
    </div>
    <!-----//end-copyright---->




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