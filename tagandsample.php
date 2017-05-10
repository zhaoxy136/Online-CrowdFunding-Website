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
$requestname = $_GET["requestname"];

$query0 = $conn->prepare("SELECT ProjID FROM Projects WHERE ProjName='$requestname'");
$query0->execute();
$query0->bind_result($requestid);
$query0->fetch();
$query0->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Complete Request</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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

        #sampleupload{
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
                <li><a href="homepage.php">Home</a></li>
                <li><a href="explore.php">Explore</a></li>
                <li class="active"><a href ="fundrequest.php">Start a project</a></li>
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
            <h1>One More Step...</h1>
            <br>


        </div>

        <div class="container blockmargin">
            <div class="col-md-12  text-center">

                <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group form-margin">
                    <hr>

                    <label class="control-label" style=""><h3>Select Tags for your project：</h3></label>
                    <div class = "row" style="font-family:Chalkduster;font-size: xx-large">
                    <br><br/>
                        <input type="checkbox" name="tags[]" value="Art"> <label> Art </label>
                        <input type="checkbox" name="tags[]" value="Books"> <label> Books </label>
                        <input type="checkbox" name="tags[]" value="Comedy"> <label> Comedy </label>
                        <input type="checkbox" name="tags[]" value="Culture"> <label> Culture </label>
                        <input type="checkbox" name="tags[]" value="Dance"> <label> Dance </label>

                        <input type="checkbox" name="tags[]" value="Drama"> <label> Drama </label>
                        <input type="checkbox" name="tags[]" value="Education"> <label> Education </label>
                        <br>
                        <input type="checkbox" name="tags[]" value="Entertainment"> <label> Entertainment </label>
                        <input type="checkbox" name="tags[]" value="Fashion"> <label> Fashion </label>

                        <input type="checkbox" name="tags[]" value="Fitness"> <label> Fitness </label>
                        <input type="checkbox" name="tags[]" value="Food"> <label> Food </label>
                        <input type="checkbox" name="tags[]" value="Games"> <label> Games </label>
                        <br>
                        <input type="checkbox" name="tags[]" value="Hiphop"> <label> Hiphop </label>
                        <input type="checkbox" name="tags[]" value="Jazz"> <label> Jazz </label>
                        <input type="checkbox" name="tags[]" value="Life"> <label> Life </label>

                        <input type="checkbox" name="tags[]" value="Movie"> <label> Movie </label>
                        <input type="checkbox" name="tags[]" value="Music"> <label> Music </label>
                        <input type="checkbox" name="tags[]" value="Mystery"> <label> Mystery </label>
                        <input type="checkbox" name="tags[]" value="Photography"> <label> Photography </label>
                        <br>
                        <input type="checkbox" name="tags[]" value="Pop"> <label> Pop </label>

                        <input type="checkbox" name="tags[]" value="Rock"> <label> Rock </label>
                        <input type="checkbox" name="tags[]" value="Sci-Fi"> <label> Sci-Fi </label>
                        <input type="checkbox" name="tags[]" value="Show"> <label> Show </label>
                        <input type="checkbox" name="tags[]" value="Technology"> <label> Technology </label>
                        <input type="checkbox" name="tags[]" value="Travel"> <label> Travel </label>
                    </div>



                    <br/><hr><br/>


                    <div class = "row">
                        <label class="control-label"><h3>And....upload some samples </h3></label>
                        <br/><br/>


                        <input id="sampleupload" type="file" style="display:none" name="sample">
                        <div class="input-append">
                            <input id="photoCover" class="input-large" type="text" style="height:30px; border: 2px solid;
            color: black;" >
                            <a class="btn" onclick="$('input[id=sampleupload]').click();">Browse</a>
                        </div>






                        <br/>
                            <textarea class="tarea" placeholder="Description" name="sampledscrp"></textarea>
                    </div>
                    <br/>

                    <button name="cmp" type="submit" class="btn btn-success" >Complete Request</button>
                </div>
                </form>

            <?php
                if(isset($_POST['cmp'])){

                //if(isset($_POST['sample'])|| isset($_POST["tags"])) {

                    //if (isset($_POST['tags'])) {

                        $alltags = $_POST["tags"];

                        foreach ($alltags as $tag) {

                        $tagquery = $conn->prepare("INSERT INTO Label(ProjID, Tag) VALUES ('$requestid','$tag')");

                        $tagquery->execute();
                        $tagquery->close();

                        }
                    //}

                    //if (isset($_POST['sample'])) {
                        $samplepath = 'Materials/'.basename($_FILES['sample']['name']);

                        move_uploaded_file($_FILES['sample']['tmp_name'], $samplepath);

                        $samplename = basename($_FILES['sample']['name']);

                        $sampletime = date('Y-m-d H:i:s');
                        $sampledscrp = test_input($_POST['sampledscrp']);


                        $materialquery = $conn->prepare("INSERT INTO Materials(MName, UID, MPath, UploadTime, MDescription) VALUES ('$samplename','$loginuser','$samplepath','$sampletime','$sampledscrp')");
                        $materialquery->execute();
                        $materialquery->close();


                        $selectmid = $conn->prepare("SELECT MID FROM Materials WHERE MName = '$samplename'");
                        $selectmid->execute();
                        $selectmid->bind_result($mid);
                        $selectmid->fetch();
                        $selectmid->close();


                        $samplequery = $conn->prepare("INSERT INTO Attach(MID, ProjID) VALUES ('$mid','$requestid')");
                        $samplequery->execute();
                        $samplequery->close();

                    //}

                    echo "<script>alert('Complete!')</script>";

                    echo "<script>location.href='project.php?projectname=$requestname'</script>";

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
    $('input[id=sampleupload]').change(function() {
        $('#photoCover').val($(this).val());
    });
</script>


</body>
</html>


