<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/4/28
 * Time: 下午5:31
 */
session_start();

require 'connection.php';
require 'function.php';


$loginuser = $_SESSION['loginuser'];




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    date_default_timezone_set('America/New_York');


    $requestname = $_POST['q1'];
    $requestdscp = $_POST['q2'];
    $requestminfund = $_POST['q3'];
    $requestmaxfund = $_POST['q4'];
    $requestfundendtime = $_POST['q5'];
    $requesttargettime = $_POST['q6'];



    $requestposttime = date('Y-m-d H:i:s');
    $requeststatus = "funding";

    $requestowner = $loginuser;

    $requestid = "86666";

/*
    echo $requestname;
    echo $requestdscp;
    echo $requestminfund;
    echo $requestmaxfund;
    echo $requestfundendtime;
    echo $requesttargettime;



    echo $requestposttime;
    echo $requeststatus;

*/

    $insertquery = $conn->prepare("INSERT INTO Projects(ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
                          VALUES ('$requestid', '$requestname', '$requestdscp', '$requestowner', '$requestminfund', '$requestmaxfund', '$requestposttime', '$requestfundendtime', null,'$requesttargettime',null, null,null, null, '$requeststatus', null)");

    $insertquery -> execute();
    $insertquery ->close();

   echo "<script>location.href='tagandsample.php?projectname=$requestname'</script>";

}else{


?>


<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Start a project</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="css/demo.css"/>
    <link rel="stylesheet" type="text/css" href="css/component.css"/>
    <link rel="stylesheet" type="text/css" href="css/cs-select.css"/>
    <link rel="stylesheet" type="text/css" href="css/cs-skin-boxes.css"/>

    <script src="js/modernizr.custom.js"></script>


    <style>


        .navbar-brand {
            font-size: 1.8em;
        }

        #topContainer {

        }

        #topRow h1 {
            font-size: 300%;

        }

        .center {
            text-align: center;
        }

        .form-control {
            display: block;
            width: 50%;
        }


    </style>

</head>
<body>


<div class="navbar-default navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>
            <a class="navbar-brand">Spring Board</a>

        </div>

        <div class="collapse navbar-collapse">

            <ul class="nav navbar-nav">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="explore.php">Explore</a></li>
                <li class="active"><a href="fundrequest.php">Start a project</a></li>
            </ul>

            <?php

            if (isset($loginuser)) {

                //echo "welcome $loginuser ";

                //echo " <button type=\"button\" class =\"btn btn-danger\" onclick=\"window.location.href='logout.php'\">Bye Bitch</button>";

                echo "
            
            <div class=\"navbar-text navbar-right dropdown\">
                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">
                   $loginuser<span class=\"caret\" ></span></a>
                    <ul class=\"dropdown-menu\">
                      <li><a href = \"profile.php?userid=$loginuser\"> My Profile </a></li>
                      <li><a href = \"editProfile.php\"> Settings</a></li>
                      <li><a href = \"logout.php\"> Log Out </a></li>
                  </ul>
                </div> ";


            } else {


                ?>

                <form class="navbar-form navbar-right" method="POST" action="loginCheck.php">

                    <div class="form-group">

                        <input type="text" class="form-control" placeholder="Username" name="loginname">

                        <input type="password" class="form-control" placeholder="*****" name="password">

                        <input type="submit" class="btn btn-success" value="Log In">

                    </div>

                    <button type="button" class="btn btn-danger" onclick="window.location.href='signup.php'">Sign Up
                    </button>

                </form>


                <?php
            }
            ?>


        </div>
    </div>
</div>

<div class="fs-form-wrap" id="fs-form-wrap" style="margin-top: 50px;">
    <div class="fs-title">
        <h1>Start your own dream by post a funding request right now</h1>
    </div>
    <form id="myform" class="fs-form fs-form-full" autocomplete="off" action="fundrequest.php" method="post">
        <ol class="fs-fields">
            <li>
                <label class="fs-field-label fs-anim-upper" for="q1">What's Your Project Name?</label>
                <input class="fs-anim-lower" id="q1" name="q1" type="text" placeholder="Project Name" required/>
            </li>
            <li>
                <label class="fs-field-label fs-anim-upper" for="q2">Describe your project in 140 words</label>
                <textarea class="fs-anim-lower" id="q2" name="q2" placeholder="Describe here" required></textarea>
            </li>
            <li>
                <label class="fs-field-label fs-anim-upper" for="q3">How much is your MINIMUM budget?</label>
                <input class="fs-mark fs-anim-lower" id="q3" name="q3" type="number" placeholder="1000" step="50"
                       min="100" required/>
            </li>
            <li>
                <label class="fs-field-label fs-anim-upper" for="q4">How much is your MAXIMUM expected value?</label>
                <input class="fs-mark fs-anim-lower" id="q4" name="q4" type="number" placeholder="5000" step="50"
                       min="100" required/>
            </li>

            <li>
                <label class="fs-field-label fs-anim-upper" for="q5">When would your funding end?</label>
                <input class="fs-anim-lower" id="q5" name="q5" type="text" placeholder="Format:2017-01-01 13:00:00" required/>
            </li>

            <li>
                <label class="fs-field-label fs-anim-upper" for="q6">When would your project be completed idealy?</label>
                <input class="fs-anim-lower" id="q6" name="q6" type="text" placeholder="Format:2017-01-01 13:00:00" required/>
            </li>



        </ol><!-- /fs-fields -->
        <button class="fs-submit" type="submit">Post Request :)</button>

    </form><!-- /fs-form -->


</div><!-- /fs-form-wrap -->


<?php
}
?>




<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

    <script src="js/classie.js"></script>
    <script src="js/selectFx.js"></script>
    <script src="js/fullscreenForm.js"></script>

<script>


        (function() {
            var formWrap = document.getElementById( 'fs-form-wrap' );

            [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
                new SelectFx( el, {
                    stickyPlaceholder: false,
                    onChange: function(val){
                        document.querySelector('span.cs-placeholder').style.backgroundColor = val;
                    }
                });
            } );

            new FForm( formWrap, {
                onReview : function() {
                    classie.add( document.body, 'overview' ); // for demo purposes only
                }
            } );
        })();



</script>



</body>
</html>