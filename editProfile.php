
<?php
	require 'connection.php';
	require 'function.php';
    session_start();
    $loginuser = $_SESSION['loginuser'];
    if (!isset($loginuser)) {
        echo "<script>alert('Please Log in First!')</script>";
        echo "<script>location.href='homepage.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Personal Settings</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet" type="text/css">

    <style type="text/css">
        body {
            background: url("images/pinkbackground.png") no-repeat center center scroll;
            background-size: cover;
        }
        .navbar-brand{
            font-size: 1.8em;
        }
    	.profileform{
    		position: relative;
    		margin-top: 50px;
    		margin-left: auto;
    		margin-right: auto;
    		width: 1100px;
    		height: 700px;
    	}
    	span.form-margin{
    		margin-left: 30px;
    		margin-right: 20px;
    	}
    	.form-margin{
    		margin-left: 50px;
    		margin-right: 50px;
    	}

    	.btn-margin{
    		margin-left: 100px;
    	}
        .show {
            margin-top: 3px;
            width: 100px;
            height: 100px;
        }
        .user_icon{
          margin: 0 5px;
          width: 20px;
          height: 20px;
          display: inline;
          padding: 0;
          border: 1px solid rgba(0,0,0,0);
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

            <?php
                $query1 = $conn->prepare("SELECT Avatar FROM UserProfiles WHERE UID = ?");
                $query1->bind_param("s", $loginuser);
                $query1->execute();
                $query1->bind_result($icon);
                $query1->fetch();
                $query1->close();
            ?>
            <ul class="navbar-text navbar-right dropdown">
                <!-- User icon -->
                  <?php 
                      if ($icon != null){
                          echo '<img src="' . $icon . '" class = "thumbnail user_icon" >';
                      }
                  ?>
                  <!-- Drop Down -->
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $loginuser ?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="timeline.php">My Timeline</a></li>
                      <li><a href="profile.php?userid=<?php echo $loginuser; ?>">My Profile</a></li>
                      <li><a href="editProfile.php">Settings</a></li>
                      <li><a href="logout.php">Log Out</a></li>
                  </ul>

              </ul>
           </div>
        </div>
    </div>
    	<?php

    		$avatarErr = $phoneErr = $emailErr = $cardErr = $interestsErr = "";
    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    			$firstname = test_input($_POST['firstname']);
    			$lastname = test_input($_POST['lastname']);
    			$gender = test_input($_POST['gender']);
    			$city = test_input($_POST['city']);
    			$state = test_input($_POST['state']);

                if ($_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
    			//if (isset($_FILES['avatar']['name'])) { //always yes
                //if (isset($_POST['avatar'])) { //always no
                //echo "<script>alert('hh')</script>";
    			  $icon_size = $_FILES['avatar']['size'];
                  if ($icon_size != 0) {
                    $target_file = "userAvatars/" .date('Ymdhis').basename($_FILES['avatar']['name']);
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    //Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES['avatar']['tmp_name']);
                    if ($check === false) {
                        $avatarErr = "File is not an image.";
                    }
                    //check file size
                    elseif ($icon_size > 500000) {
                        $avatarErr = "Sorry, your file is too large.";
                    }
                    // Allow certain file formats
                    elseif ($imageFileType !="jpg" && $imageFileType !="png" && $imageFileType !="jpeg") {
                        $avatarErr = "Sorry, only JPG, JPEG, PNG and GIF files are allowed.";
                    }
                    // Check if file already exists
                    elseif (file_exists($target_file)) {
                        $avatarErr = "This image already exists.";
                    }
                  }
    			} else {
                    //echo "<script>alert('no')</script>";
                    $target_file = $_POST['avalink'];
                }

    			$phone = test_input($_POST['phone']);
    			if (!empty($_POST['phone']) && preg_match("/[^0-9]/", $phone)) {
    				$phoneErr = "phone number is Invalid!";
    			}
    			$email = test_input($_POST['email']);
    			if (!empty($_POST['email']) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      				$emailErr = "email is Invalid!";
    			}
    			
    			if (!empty($_POST['card'])){
    				$card = test_input($_POST['card']);
    				if (strlen($card) != 16 || preg_match("/[^0-9]/", $card)) {
    					$cardErr = "creditcard is Invalid!";
    				}
    			}
    			$interests = test_input($_POST['interests']);
    			if (strlen($interests) > 140) {
    				$interestsErr = "Your interests statement are over character limit.";
    			}
    			//update to database
    			if ($avatarErr == "" && $phoneErr == "" && $emailErr == "" && $cardErr == "" && $interestsErr == "") {

    				move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
    				$updateProf = $conn->prepare("UPDATE UserProfiles SET FirstName = ?, LastName = ?, Avatar = ?, Gender = ?, City = ?, State = ?, Cellphone = ?, EmailAddress = ?, CreditCardNumber = ?, Interests = ? WHERE UID = ?");
    				$updateProf->bind_param("sssssssssss", $firstname, $lastname, $target_file, $gender, $city, $state, $phone, $email, $card, $interests, $loginuser);
    				$updateProf->execute();
    				$updateProf->close();
    			}

    		}//end if post
    		$user = array("username" => "", "firstname" => "", "lastname" => "", "avatar" => "", "gender" => "", "city" => "", "state" => "", "phone" => "", "email" => "", "card" => "", "interests" => "");

    		$query1 = $conn->prepare("SELECT * FROM UserProfiles WHERE UID = '$loginuser'");
    		$query1->execute();
    		$query1->bind_result($user['username'], $user['firstname'], $user['lastname'], $user['avatar'], $user['gender'], $user['city'], $user['state'], $user['phone'], $user['email'], $user['card'], $user['interests']);
    		$query1->fetch();

    		$query1->close();

    	?>
	
    <div class="profileform">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    	<div class="row">
    	<h1 style="text-align: center;">Please complete your profile!</h1>
    	</div>
    	<hr>
    	<div class="row">
    	<div class="col-md-6">
    		<div class="form-group form-margin">
    			<label for="profileInputUsername">UserName</label>
    			<input type="text" class="form-control" id="profileInputUsername" aria-describedby="usernameHelp" name="username" value=<?php echo $user['username'];?> disabled>
			    <small id="usernameHelp" class="form-text text-muted">If you want to change username, please click <a href="#Accounts">here</a>.</small>
			</div>
			<div class="form-group form-margin">
    			<label for="profileInputAvatar">Profile Photo</label><span class="error form-margin"><strong style="color: red;"><?php echo $avatarErr;?></strong></span>
    			<input type="file" name="avatar" id="profileInputAvatar">
                <input type="hidden" name="avalink" value="<?php echo $user['avatar'];?>">
                <img class="show" src="<?php echo $user['avatar']; ?>" onerror="this.src='images/defaulticon.jpg';" class="avatar">
			</div>

    		<div class="form-group form-margin" style="clear: left;">
				<label for="profileInputPhone">Cellphone</label><span class="error form-margin"><strong style="color: red;"><?php echo $phoneErr;?></strong></span>
    			<input type="text" class="form-control" id="profileInputPhone" name="phone" value="<?php echo isset($phone) ? $phone : $user['phone'];?>">
    		</div>
    		<div class="form-group form-margin">
				<label for="profileInputInterest">Please state your interests:</label><span class="error form-margin"><strong style="color: red;"><?php echo $interestsErr;?></strong></span>
    			<textarea class="form-control" id="profileInputInterest" rows="5" name="interests"><?php echo $user['interests'];?></textarea>
    		</div>
    	</div>

    	<div class="col-md-6">
    		<div class="form-group form-margin">
				<label for="profileInputFirstname">FirstName</label>
    			<input type="text" class="form-control" id="profileInputFirstname" name="firstname" value="<?php echo isset($firstname) ? $firstname : $user['firstname'];?>">
    		</div>
    		<div class="form-group form-margin">
				<label for="profileInputLastname">LastName</label>
    			<input type="text" class="form-control" id="profileInputLastname" name="lastname" value="<?php echo isset($lastname) ? $lastname : $user['lastname'];?>">
    		</div>
    		<fieldset class="form-group form-margin">
    		<label>Gender</label>
    			<span class="form-check form-margin">
      			<label class="form-check-label">
        			<input type="radio" class="form-check-input" name="gender" value="Male" <?php if (isset($user['gender']) && $user['gender']=="Male") echo "checked";?>>  Male
      			</label>
      			</span>
      			<span class="form-check form-margin">
      			<label class="form-check-label">
        			<input type="radio" class="form-check-input" name="gender" value="Female" <?php if (isset($user['gender']) && $user['gender']=="Female") echo "checked";?>>   Female
      			</label>
      			</span>
 			</fieldset>
 			<div class="form-group form-margin">
				<label for="profileInputCity">City</label>
    			<input type="text" class="form-control" id="profileInputCity" name="city" value="<?php echo isset($city) ? $city : $user['city'];?>">
    		</div>
    		<div class="form-group form-margin">
    			<label for="profileInputState">State</label>
    			<select class="form-control" id="profileInputState" name="state">
				  	<option value="">Select a State</option>
				  	<option value="AL" <?php if (isset($user['state']) && $user['state']=="AL") echo "selected";?>>AL</option>
					<option value="AK" <?php if (isset($user['state']) && $user['state']=="AK") echo "selected";?>>AK</option>
					<option value="AZ" <?php if (isset($user['state']) && $user['state']=="AZ") echo "selected";?>>AZ</option>
					<option value="AR" <?php if (isset($user['state']) && $user['state']=="AR") echo "selected";?>>AR</option>
					<option value="CA" <?php if (isset($user['state']) && $user['state']=="CA") echo "selected";?>>CA</option>
					<option value="CO" <?php if (isset($user['state']) && $user['state']=="CO") echo "selected";?>>CO</option>
					<option value="CT" <?php if (isset($user['state']) && $user['state']=="CT") echo "selected";?>>CT</option>
					<option value="DE" <?php if (isset($user['state']) && $user['state']=="DE") echo "selected";?>>DE</option>
					<option value="DC" <?php if (isset($user['state']) && $user['state']=="DC") echo "selected";?>>DC</option>
					<option value="FL" <?php if (isset($user['state']) && $user['state']=="FL") echo "selected";?>>FL</option>
					<option value="GA" <?php if (isset($user['state']) && $user['state']=="GA") echo "selected";?>>GA</option>
					<option value="HI" <?php if (isset($user['state']) && $user['state']=="HI") echo "selected";?>>HI</option>
					<option value="ID" <?php if (isset($user['state']) && $user['state']=="ID") echo "selected";?>>ID</option>
					<option value="IL" <?php if (isset($user['state']) && $user['state']=="IL") echo "selected";?>>IL</option>
					<option value="IN" <?php if (isset($user['state']) && $user['state']=="IN") echo "selected";?>>IN</option>
					<option value="IA" <?php if (isset($user['state']) && $user['state']=="IA") echo "selected";?>>IA</option>
					<option value="KS" <?php if (isset($user['state']) && $user['state']=="KS") echo "selected";?>>KS</option>
					<option value="KY" <?php if (isset($user['state']) && $user['state']=="KY") echo "selected";?>>KY</option>
					<option value="LA" <?php if (isset($user['state']) && $user['state']=="LA") echo "selected";?>>LA</option>
					<option value="ME" <?php if (isset($user['state']) && $user['state']=="ME") echo "selected";?>>ME</option>
					<option value="MD" <?php if (isset($user['state']) && $user['state']=="MD") echo "selected";?>>MD</option>
					<option value="MA" <?php if (isset($user['state']) && $user['state']=="MA") echo "selected";?>>MA</option>
					<option value="MI" <?php if (isset($user['state']) && $user['state']=="MI") echo "selected";?>>MI</option>
					<option value="MN" <?php if (isset($user['state']) && $user['state']=="MN") echo "selected";?>>MN</option>
					<option value="MS" <?php if (isset($user['state']) && $user['state']=="MS") echo "selected";?>>MS</option>
					<option value="MO" <?php if (isset($user['state']) && $user['state']=="MO") echo "selected";?>>MO</option>
					<option value="MT" <?php if (isset($user['state']) && $user['state']=="MT") echo "selected";?>>MT</option>
					<option value="NE" <?php if (isset($user['state']) && $user['state']=="NE") echo "selected";?>>NE</option>
					<option value="NV" <?php if (isset($user['state']) && $user['state']=="NV") echo "selected";?>>NV</option>
					<option value="NH" <?php if (isset($user['state']) && $user['state']=="NH") echo "selected";?>>NH</option>
					<option value="NJ" <?php if (isset($user['state']) && $user['state']=="NJ") echo "selected";?>>NJ</option>
					<option value="NM" <?php if (isset($user['state']) && $user['state']=="NM") echo "selected";?>>NM</option>
					<option value="NY" <?php if (isset($user['state']) && $user['state']=="NY") echo "selected";?>>NY</option>
					<option value="NC" <?php if (isset($user['state']) && $user['state']=="NC") echo "selected";?>>NC</option>
					<option value="ND" <?php if (isset($user['state']) && $user['state']=="ND") echo "selected";?>>ND</option>
					<option value="OH" <?php if (isset($user['state']) && $user['state']=="OH") echo "selected";?>>OH</option>
					<option value="OK" <?php if (isset($user['state']) && $user['state']=="OK") echo "selected";?>>OK</option>
					<option value="OR" <?php if (isset($user['state']) && $user['state']=="OR") echo "selected";?>>OR</option>
					<option value="PA" <?php if (isset($user['state']) && $user['state']=="PA") echo "selected";?>>PA</option>
					<option value="RI" <?php if (isset($user['state']) && $user['state']=="RI") echo "selected";?>>RI</option>
					<option value="SC" <?php if (isset($user['state']) && $user['state']=="SC") echo "selected";?>>SC</option>
					<option value="SD" <?php if (isset($user['state']) && $user['state']=="SD") echo "selected";?>>SD</option>
					<option value="TN" <?php if (isset($user['state']) && $user['state']=="TN") echo "selected";?>>TN</option>
					<option value="TX" <?php if (isset($user['state']) && $user['state']=="TX") echo "selected";?>>TX</option>
					<option value="UT" <?php if (isset($user['state']) && $user['state']=="UT") echo "selected";?>>UT</option>
					<option value="VT" <?php if (isset($user['state']) && $user['state']=="VT") echo "selected";?>>VT</option>
					<option value="VA" <?php if (isset($user['state']) && $user['state']=="VA") echo "selected";?>>VA</option>
					<option value="WA" <?php if (isset($user['state']) && $user['state']=="WA") echo "selected";?>>WA</option>
					<option value="WV" <?php if (isset($user['state']) && $user['state']=="WV") echo "selected";?>>WV</option>
					<option value="WI" <?php if (isset($user['state']) && $user['state']=="WI") echo "selected";?>>WI</option>
					<option value="WY" <?php if (isset($user['state']) && $user['state']=="WY") echo "selected";?>>WY</option>
				</select>
  			</div>
  			<div class="form-group form-margin">
				<label for="profileInputEmail">Email</label><span class="error form-margin"><strong style="color: red;"><?php echo $emailErr;?></strong></span>
    			<input type="text" class="form-control" id="profileInputEmail" name="email" value="<?php echo isset($email) ? $email : $user['email'];?>">
    		</div>
  			<div class="form-group form-margin">
				<label for="profileInputCard">CreditCard</label><span class="error form-margin"><strong style="color: red;"><?php echo $cardErr;?></strong></span>
    			<input type="text" class="form-control" id="profileInputCard" name="card" value="<?php echo isset($card) ? $card : $user['card'];?>">
    		</div>
 		</div>
 		</div>

 		<hr>
 		<div class="row">
    		<input type="submit" class="btn btn-success btn-margin btn-lg" name="commit" value="Save">
    		<a class="btn" href="profile.php?userid=<?php echo $loginuser;?>">View profile</a>
 		</div>
    	</form>
    </div>
    <?php
    	unset($user);
    	?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>


