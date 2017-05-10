<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/5/3
 * Time: 下午9:25
 */
session_start();

require 'connection.php';
require 'function.php';

$loginuser = $_SESSION['loginuser'];
if (!isset($loginuser)) {
    echo "<script>alert('Please Log in First!')</script>";
    echo "<script>location.href='homepage.php'</script>";
}
$projectid = $_GET["projectid"];
$projname = $_GET["projectname"];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Update Project</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet" type="text/css">
    <style type="text/css">
        body{
            background: url("images/darkblue.jpg") no-repeat center center scroll;
            background-size: cover;
        }
        .navbar-brand {
            font-size: 1.8em;
        }
        .completerequest{
            position: relative;
            margin-top: 200px;
            margin-left: auto;
            margin-right: auto;
            width: 1200px;
            height: 800px;
            text-align: center;
            color: white;
        }
        span.form-margin{
            margin-left: 30px;
            margin-right: 20px;
        }
        .form-margin{
            margin-left: 100px;
            margin-right: 100px;
        }

        .sample{
            overflow: hidden;
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

        .blockmargin{

            margin-left: auto;
            margin-right: auto;
        }

        #updateupload{

            margin-left: auto;
            margin-right:auto;
        }

        .tarea{
            color: black;
            border:3px double green;
            width:300px;
            overflow-y:visible
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
                    $query0 = $conn->prepare("SELECT Avatar FROM UserProfiles WHERE UID = ?");
                    $query0->bind_param("s", $loginuser);
                    $query0->execute();
                    $query0->bind_result($icon);
                    $query0->fetch();
                    $query0->close();
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

    <div class="completerequest" ">



    <div class="row" style="color: lavenderblush;font-family: Chalkduster">
        <h1>How is your project going?</h1>
        <br>
    </div>

    <div class="container blockmargin">
        <div class="col-md-12 text-center">
                <br><br>

            <div class = "row">
                <form method="post" action="">

                <button name="cplt" type="submit" class="btn btn-success" >I have completed it!</button>


                <?php

                if (isset($_POST['cplt'])) {

                    $cplttime = date('Y-m-d H:i:s');

                    $cpltquery = $conn->prepare("UPDATE Projects SET Status='Completed', CompleteTime='$cplttime' WHERE ProjID='$projectid' ");
                    $cpltquery -> execute();
                    $cpltquery ->close();



                    echo "<script>alert('Congratulations!')</script>";

                    echo "<script>location.href='project.php?projectname=$projname'</script>";

                }

                ?>
                </form>
            </div>
            <br>
            <hr>


            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group form-margin">

                    <div class = "row">

                        <label class="control-label"><h3>Make some updates for your sponsors :)</h3></label>
                        <br/><br/>


                        <input id="updateupload" type="file" style="display:none" name="update">
                        <div class="input-append">
                            <input id="photoCover" class="input-large" type="text" style="height:30px; border: 2px solid;color: black;">
                            <a class="btn" onclick="$('input[id=updateupload]').click();">Browse</a>
                        </div>

                        <br/>

                        <textarea class="tarea" placeholder="Description" name="updatedscrp" style="color: black"></textarea>

                    </div>
                    <br/>

                    <button name="upt" type="submit" class="btn btn-success" >Update</button>
                </div>
            </form>

        <?php

            if (isset($_POST['upt'])) {

                $updatepath = 'Materials/'. basename($_FILES['update']['name']);

                move_uploaded_file($_FILES['update']['tmp_name'], $updatepath);



                $updatename = basename($_FILES['update']['name']);

                $updatetime = date('Y-m-d H:i:s');
                $updatedscrp = test_input($_POST['updatedscrp']);



                $materialquery = $conn->prepare("INSERT INTO Materials(MName, UID, MPath, UploadTime, MDescription) 
                                                            VALUES ('$updatename','$loginuser','$updatepath','$updatetime','$updatedscrp')");
                $materialquery -> execute();
                $materialquery ->close();


                $selectmid = $conn->prepare("SELECT MID FROM Materials WHERE MName = '$updatename'");
                $selectmid -> execute();
                $selectmid->bind_result($mid);
                $selectmid->fetch();
                $selectmid ->close();


                $updatequery = $conn->prepare("INSERT INTO StageUpdate(UID, ProjID, MID, UpdateTime) VALUES ('$loginuser','$projectid','$mid','$updatetime')");
                $updatequery -> execute();
                $updatequery ->close();


                echo "<script>alert('Update Success!')</script>";

                echo "<script>location.href='project.php?projectname=$projname'</script>";

            }

        ?>

        </div>

    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>



    <script type="text/javascript">
        $('input[id=updateupload]').change(function() {
            $('#photoCover').val($(this).val());
        });
    </script>


</body>
</html>

