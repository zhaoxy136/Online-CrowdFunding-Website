<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/4/27
 * Time: 下午2:12
 */
session_start();
require 'connection.php';
require 'function.php';

    $loginuser = $_SESSION['loginuser'];
    if (!isset($_GET['projectname'])) {
        echo "<script>location.href='homepage.php'</script>";
    }
    //Set Cookies
    setcookie("visituser",$loginuser,time()+60*60*24*30);
    setcookie("visitproj",$_GET["projectname"],time()+60*60*24*30);

    $projectname = $_GET["projectname"];
    $getproj = $conn->prepare("SELECT ProjID FROM Projects WHERE ProjName = '$projectname'");
    $getproj->execute();
    $getproj->bind_result($pid);
    $getproj->fetch();
    $getproj->close();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['like'])) {
            $subquery11 = $conn->prepare("INSERT INTO Likes (UID, ProjID) VALUES ('$loginuser', '$pid')");
            $subquery11->execute();
            $subquery11->close();
        } elseif (isset($_POST['unlike'])) {
            $subquery12 = $conn->prepare("DELETE FROM Likes WHERE UID = '$loginuser' AND ProjID = '$pid'");
            $subquery12->execute();
            $subquery12->close();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Project Details</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/htmleaf-demo.css">


    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/star-rating.min.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>



    <style>


        .navbar-brand{
            font-size: 1.8em;
        }

        #topContainer{
            background-image:url("images/oldwhitebackground.jpg");

        }

        #topRow{
            margin-top: 100px;
            text-align:center;

        }

        #topRow h1 {
            font-size: 300%;

        }

        .center{
            text-align: center;
        }

        .link{
            color: #449D44;
        }

        .projmarginBottom{
            margin-bottom: 100px;
        }

        .infotext{
            margin-left: auto;
            margin-right: auto;
            width:500px;
        }

        #btmContainer{
            margin-bottom: auto;
        }

        .projstatus{
            color: #FF0000;
        }

        .demo{padding: 1em 0;}
        a:hover,a:focus{
            outline: none;
            text-decoration: none;
        }
        .tab .nav-tabs{
            border: 1px solid #b7ddb5;
        }
        .tab .nav-tabs li{
            margin: 0;
        }
        .tab .nav-tabs li a{
            font-size: 14px;
            color: #999898;
            background: #fff;
            margin: 0;
            padding: 20px 25px;
            border-radius: 0;
            border: none;
            border-right: 1px solid #ddd;
            text-transform: uppercase;
            position: relative;
        }
        .tab .nav-tabs li a:hover{
            border-top: none;
            border-bottom: none;
            border-right-color: #ddd;
        }
        .tab .nav-tabs li.active a,
        .tab .nav-tabs li.active a:hover{
            color: #fff;
            border: none;
            background: #b7ddb5;
            border-right: 1px solid #ddd;
        }
        .tab .nav-tabs li.active a:before{
            content: "";
            width: 58%;
            height: 4px;
            background: #fff;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin: 0 auto;
        }
        .tab .nav-tabs li.active a:after{
            content: "";
            border-top: 10px solid #b7ddb5;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            position: absolute;
            bottom: -10px;
            left: 43%;
        }
        .tab .tab-content{
            font-size: 13px;
            color: #999898;
            line-height: 25px;
            background: #fff;
            padding: 20px;
            border: 1px solid #b7ddb5;
            border-top: none;
        }
        .tab .tab-content h3{
            font-size: 24px;
            color: #999898;
            margin-top: 0;
        }
        @media only screen and (max-width: 480px){
            .tab .nav-tabs li{
                width: 100%;
                text-align: center;
            }
            .tab .nav-tabs li.active a,
            .tab .nav-tabs li.active a:after,
            .tab .nav-tabs li.active a:hover{
                border: none;
            }
        }
        .bggly{
            font-size: 25px;
        }
        .btn-hide{
            border: 0;
            padding: 0;
            outline: 0;
            background: transparent;
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


<div class ="navbar-default navbar-fixed-top">
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
                <li class="active"><a href="explore.php">Explore</a></li>
                <li><a href ="fundrequest.php">Start a project</a></li>
            </ul>

            <?php
                if(isset($loginuser)) {
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
            <?php
                } else {
            ?>
                <form class="navbar-form navbar-right" method="POST" action="loginCheck.php">

                <div class="form-group">

                    <input type="text" class="form-control" placeholder="Username" name="loginname">
                    <input type="password" class="form-control" placeholder="*****" name="password">
                    <input type="submit" class="btn btn-success"  value="Log In">
                </div>

                <button type="button" class ="btn btn-danger" onclick="window.location.href='signup.php'">Sign Up</button>

                </form>

            <?php
                }
            ?>
        </div>
    </div>
</div>


<div class="container contentContainer" id="topContainer">


    <div class="row center projmarginBottom infotext" id="topRow">

        <br/>

        <?php

        $query0 = $conn->prepare("SELECT * FROM Projects WHERE ProjName='$projectname'");
        $query0 -> execute();
        $query0 -> bind_result($projid,$projname,$description,$ownerid,$minfundvalue,$maxfundvalue,$posttime,
            $fundingendtime, $starttime, $targettime, $completetime, $likecount, $sponsorcount, $alreadyfund, $status, $avgrating);
        $query0->fetch();
        $query0->close();
        //$res0 = $query0->get_result();

        echo "<div><h1 class=\"center\">".$projectname. "</h1></div>";
        echo "<div class=\"center lead\">".$description. "</div>";

         // echo "<div><h2 class=\"center\">".$description. "</h2></div>";
        $query1 = $conn->prepare("SELECT * FROM UserProfiles WHERE UID='$ownerid'");
        $query1 -> execute();
        $query1 -> bind_result($uid,$firstname,$lastname,$avatar,$gender,$city,$state,$cellphone,
                    $emailaddress, $creditcardnumber, $interests);
        $query1->fetch();

        $query1->close();


        if (isset($loginuser)) {
            $query11 = $conn->prepare("SELECT * FROM Likes WHERE UID = '$loginuser' AND ProjID = '$projid'");
            $query11->execute();
            if ($query11->fetch()) {
                //undo like, show heart
                ?>
                <form method="post" action="project.php?projectname=<?php echo $projectname;?>">
                <input type="hidden" name="unlike">
                <button type="submit" class="btn-hide"><span class="glyphicon glyphicon-heart bggly"></span></button>
                </form>
            <?php } else { 
                //like, show empty heart
                ?>
                <form method="post" action="project.php?projectname=<?php echo $projectname;?>">
                <input type="hidden" name="like">
                <button type="submit" class="btn-hide"><span class="glyphicon glyphicon-heart-empty bggly"></span></button>
                </form>
            <?php
            }
            $query11->close();
        } ?>
    </div>

</div>



<div class="container contentContainer" id="midContainer">
    <hr>

    <div class="col-md-6 marginTop center">



            <h5><span class="glyphicon glyphicon-user"></span> Project Owner</h5>

        <?php echo "<a href='profile.php?userid=$uid' class ='link'>";?>
        <h2><?php echo $firstname;?><br/>
                     <?php echo $lastname;?></h2></a>

            <h5><span class="glyphicon glyphicon-envelope"></span> Email: <?php echo $emailaddress;?></h5>

            <h5><span class="glyphicon glyphicon-cutlery"></span> Interests: <?php echo $interests;?></h5>
            <hr>

            <h5>Project Post Time: <?php echo $posttime;?></h5>

            <h5><?php echo is_null($starttime)?"Funding End Time:$fundingendtime":
                                                "Project Start Time: $starttime";?></h5>

             <h5><?php echo is_null($completetime)?"Project Target Complete Time :$targettime":
                                                "Project Complete Time: $completetime";?></h5>

    </div>

    <div class="col-md-6 marginTop">


        <div class="center">
        <h4>Project Status:</h4><h3 class="projstatus"><?php echo $status;?></h3>
        <h4>Minimum Fund Needed: <span style="color: #5CB85C">$<?php echo $minfundvalue;?></span></h4>
        <hr>
        </div>

        <ul class = "list-group">

            <li class="list-group-item">
                <span class="glyphicon glyphicon-king"></span> Sponsor Count<span class="badge"><?php echo $sponsorcount;?></span></li>
            <li class="list-group-item">
                <span class="glyphicon glyphicon-usd"></span> Already Fund<span class="badge">$<?php echo $alreadyfund;?></span></li>
            <li class="list-group-item">
                <span class="glyphicon glyphicon-thumbs-up"></span> Like Count<span class="badge"><?php echo $likecount;?></span></li>
            <li class="list-group-item">
                <span class="glyphicon glyphicon-fire"></span> Avg Rating<span class="badge"><?php echo is_null($avgrating)?"No rating":$avgrating;?></span></li>

    </div>


</div>



<div class="container contentContainer" id="btmContainer">

    <hr>

    <div class="center">

        <?php

        $query6 = $conn->prepare(
                    "SELECT Tag
                    FROM Projects natural join Label l
                    WHERE l.ProjID = '$projid'");
        $query6 -> execute();
        $query6 -> bind_result($tag);

        echo " Tags: ";
        while($query6 -> fetch()){
            echo "<td><a href ='tag.php?clicktag=$tag'>$tag</a>  </td>\n";
        }

        $query6->close();

        ?>

    <hr>


    <br/>

    </div>


    <?php

    if($status == 'Funding') {
        $query7 = $conn->prepare("SELECT UID FROM Pledges WHERE ProjID='$projid' AND UID = '$loginuser'");
        $query7->execute();
        $query7->bind_result($sponsors);

        if ($query7->fetch()) {
            echo "<h3><div style='text-align: center; color: #5CB85C'>You have already sponsored this project.</div></h3> <br/><br/>";

        } else {
            ?>
            <div class="center">

                <a class="btn btn-success btn-lg" data-toggle="modal" data-target="#pledgeModal" role="button">SPONSOR
                    IT!</a>
                <br/><br/>

            </div>
            <?php
        }
        $query7->close();

    }else if($status == 'Ongoing'){
        echo "<h3><div style='text-align: center; color: #5CB85C'>The funding period is over and $ownerid is working on this project :)</div></h3> <br/><br/>";

    }else if($status == 'Completed'){
        echo "<h3><div style='text-align: center; color: #5CB85C'>Thanks to your supports the project is completed now!</div></h3> <br/><br/>";

    }else if($status == 'Failed'){

        echo "<h3><div style='text-align: center; color: #5CB85C'>$ownerid didn't recieve enough fund...<br>Your comment will be a great comfort :)</div></h3> <br/><br/>";

    }

    ?>

    <div class="modal" id="pledgeModal">

        <div class ="modal-dialog modal-sm">

            <div class ="modal-content">

                <div class="modal-header">

                    <button class="close" data-dismiss="modal">x</button>

                    <h4 class="modal-title">Make a Pledge</h4>

                </div>


                <form name="sponsorform" role ="form" class="form-inline" method="post">
                <div class ="modal-body">

                    <div class="row">

                        <div class="col-md-12 marginTop">
                            <p class="form-group marginmiddle">
                                <span class="glyphicon glyphicon-usd"></span>
                                <input name="pledgeamount" class="form-control" type="number" placeholder="Amount" step="50" min="500"/>
                        </div>
                    </div>

                </div>

                <div class ="modal-footer">

                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Sponsor</button>
                </div>
                </form>
                <?php

                if($_POST['pledgeamount']){
                    $newpledgeuid = $loginuser;
                    $newpledgeprojid = $projid;

                    $newpledgetime = date('Y-m-d H:i:s');
                    $newpledgeamount = $_POST['pledgeamount'];
                    $newpledgecard = $creditcardnumber;

                    $pledgequery = $conn-> prepare("INSERT INTO Pledges (ProjID, UID, PledgeTime, Amount, CreditCardNumber) 
                        VALUES ('$projid','$loginuser','$newpledgetime','$newpledgeamount','$newpledgecard')");
                    $pledgequery -> execute();
                    $pledgequery -> close();

                    echo "<script>location.href='project.php?projectname=$projectname'</script>";

                }
                ?>
            </div>
        </div>
    </div>



    <div class="demo">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab" role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">Updates</a></li>
                            <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">Comments</a></li>
                            <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab">Reviews</a></li>

                        </ul>

                    <!-- Tab panes -->
                    <div class="tab-content tabs">
                        <!--Start- Updates-->
                        <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                            <h4>Updates:</h4><br/>

                        <?php

                            $query2 = $conn->prepare("SELECT MID, MDescription, MPath, UpdateTime
                                    FROM StageUpdate natural join Materials
                                    WHERE ProjID='$projid' order by UpdateTime DESC ");
                            $query2 ->execute();
                            $query2 ->bind_result($updateid, $updatedescription, $updatepath, $updatetime);


                            while ($query2->fetch()){
                                echo "<h4>$updateid</h4>
                                    <h4>$updatetime</h4>
                                    <h3>$updatedescription</h3><br/>
                                    <p><a href=\" $updatepath\" class=\"center-block\"><embed src=\" $updatepath\" class=\"img-responsive\" autostart=false /></a></p>";





                                echo "<br/>";

                            }


                            if(!$updateid){
                                echo "The project has no updates yet. <br/>";
                            }

                            $query2->close();


                            if($loginuser == $ownerid){

                                echo "<a href='update.php?projectid=$projid&projectname=$projname'><button class='btn btn-success marginTop'>Update Your Project</button></a>";
                            }


                        ?>


                        <hr>


                        <h4>Samples:</h4><br/>

                        <?php

                            $query3 = $conn->prepare("SELECT MID, MDescription, MPath
                                        FROM Attach natural join Materials
                                            WHERE ProjID='$projid' ");
                            $query3 ->execute();
                            $query3 ->bind_result($sampleid, $sampledescription, $samplepath);

                            while ($query3->fetch()){
                                echo "<h4>$sampleid</h4>
                                    <h3>$sampledescription</h3><br/>
                                    <p><a href=\" $samplepath\" class=\"center-block\"><img src=\" $samplepath\" class=\"img-responsive\" /></a></p>";
                                echo "<br/>";

                            }

                            if(!$sampleid){
                                echo "The owner didn't upload samples. ";
                            }
                            $query3->close();


                        ?>

                        </div><!--End Updates-->

                        <!--Start Comments-->
                        <div role="tabpanel" class="tab-pane fade" id="Section2">

                        <?php

                            $query4 = $conn->prepare("SELECT * FROM Comments WHERE ProjID='$projid' order by CommentTime DESC ");
                            $query4 -> execute();
                            $query4 -> bind_result($commentby, $commentproj, $commentcontent, $commenttime);

                            while ($query4->fetch()){

                                echo "<h3>$commentby</h3>
                                    <h5>$commenttime</h5>
                                    <p>$commentcontent</p><br/>";
                                echo "<br/>";

                            }

                            if(!$commentby){
                                echo "The project didn't have any comments yet. <br/><br/>";
                            }

                            $query4 -> close();

                        if (!isset($loginuser)) { ?>
                            <p style="color: #226837; font-size: 18px; font-weight: 500;">Please Login First to make a comment.</p>
                        <?php
                        } else {
                        ?>

                        <button class="btn btn-success" data-toggle ="modal" data-target="#commentModal">
                                Make a comment
                        </button>

                        <?php } ?>
                        <div class="modal" id="commentModal">

                            <div class ="modal-dialog">

                                <div class ="modal-content">

                                    <div class="modal-header">

                                        <button class="close" data-dismiss="modal">x</button>

                                            <h4 class="modal-title">Comment</h4>

                                    </div>

                                    <form name="commentform" method="post">

                                    <div class ="modal-body">

                                        <div class="row">

                                            <div class="col-md-12 marginTop">
                                                <p class="form-group marginmiddle">

                                                <textarea name="commentcontent"  class="form-control"  rows="8" placeholder="Tell the owner what you think..."></textarea></p>

                                            </div>
                                        </div>

                                    </div>


                                    <div class ="modal-footer">

                                        <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Post comment :)</button>
                                    </div>
                                    </form>


                            <?php
                                if($_POST['commentcontent']){
                                    $newcommentuid = $loginuser;
                                    $newcommentprojid = $projid;
                                    $newusercomment = $_POST['commentcontent'];
                                    $newcommenttime = date('Y-m-d H:i:s');

                                    $commentquery = $conn-> prepare("INSERT INTO Comments (UID, ProjID, UserComment, CommentTime) VALUES ('$newcommentuid', '$newcommentprojid', '$newusercomment', '$newcommenttime')");
                                    $commentquery -> execute();
                                    $commentquery ->close();

                                    echo "<script>location.href='project.php?projectname=$projectname'</script>";

                                }

                            ?>


                                </div>
                            </div>
                        </div>


                    </div><!--End Comments-->

                        <!--Start Reviews-->
                        <div role="tabpanel" class="tab-pane fade" id="Section3">

                            <?php

                            $query5 = $conn->prepare("SELECT * FROM Reviews WHERE ProjID='$projid' order by RateTime DESC ");
                            $query5 -> execute();
                            $query5 -> bind_result($rateby, $rateproj, $ratingstar, $ratetime, $reviewcontent);


                            while ($query5->fetch()){

                                echo "<h3>$rateby</h3>
                                            <h5>$ratetime</h5>";

                                for ($i=0; $i<$ratingstar; $i++) {
                                    echo "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>";
                                }

                                echo "<br/><p>$reviewcontent</p><br/>";
                                echo "<br/>";

                            }

                            if(!$rateby){
                                   echo "The project didn't have any reviews yet. <br/>";
                            }

                            $query5 -> close();


                            $query50 = $conn->prepare("SELECT Rating FROM Reviews WHERE ProjID='$projid' AND UID = '$loginuser' ");
                            $query50 -> execute();
                            $query50 -> bind_result($xixi);
                            $query50 ->fetch();
                            $query50 ->close();




                            if($status == 'Completed'){

                                $query55 = $conn->prepare("SELECT UID 
                                                                FROM Pledges 
                                                                WHERE ProjID='$projid' AND UID = '$loginuser' ");
                                $query55 -> execute();
                                $query55 -> bind_result($sponsors);


                                if ($query55->fetch()) {

                                    ?>

                                    <br/>

                                    <?php
                                    if (!isset($loginuser)) { ?>
                                        <p style="color: #226837; font-size: 18px; font-weight: 500;">Please Login First
                                            to make a review.</p>

                                        <?php
                                    } else {

                                        if (isset($xixi)) {

                                            echo "You have already reviewed it. <br/>";
                                        } else {
                                            ?>
                                            <button class="btn btn-success" data-toggle="modal"
                                                    data-target="#reviewModal">
                                                Rate this project
                                            </button>

                                            <?php

                                        }
                                    }
                                }else {
                                    echo "Review function only open to sponsors. <br/>";

                                }

                                $query55 -> close();

                            }else{

                                echo "Review function only open when the project is completed. <br/>";

                            }

                        ?>

                            <div class="modal" id="reviewModal">

                                <div class ="modal-dialog">

                                    <div class ="modal-content">

                                        <div class="modal-header">

                                            <button class="close" data-dismiss="modal">x</button>

                                            <h4 class="modal-title">Reviews</h4>

                                        </div>

                                        <form name="rateform" method="post">

                                            <div class ="modal-body">

                                                Rate from 0 to 5 stars.

                                                <br/>
                                                <input name="ratestar" id="input-21e" value="0" type="number" class="rating" min=0 max=5 step=1 data-size="xs">
                                                <br/>

                                                <div class="row">

                                                    <div class="col-md-12 marginTop">
                                                        <p class="form-group marginmiddle">

                                                            <textarea name="reviewcontent" class="form-control"  rows="8" placeholder="Do u like it?"></textarea>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class ="modal-footer">

                                                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Submit review :)</button>
                                            </div>
                                            </form>

                                            <?php

                                            if($_POST['ratestar']){

                                                //$star = $_POST['ratestar'];
                                                $newrateuid = $loginuser;
                                                $newrateprojid = $projid;
                                                $newratestar = $_POST['ratestar'];
                                                $newreviewtime = date('Y-m-d H:i:s');
                                                $newreviewcontent = $_POST['reviewcontent'];


                                                $ratequery = $conn-> prepare("INSERT INTO Reviews (UID, ProjID, Rating, RateTime, UserReview) VALUES ('$newrateuid','$newrateprojid','$newratestar','$newreviewtime', '$newreviewcontent')");
                                                $ratequery -> execute();
                                                $ratequery -> close();



                                                echo "<script>location.href='project.php?projectname=$projectname'</script>";

                                            }
                                            ?>


                                        </div>
                                    </div>
                                </div>


                            </div><!--End Reviews-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





</div>


<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h4><strong>Powered by</strong>
                </h4>
                <p> <span><a href="https://www.linkedin.com/in/renqingyu/" style="color: black;">Renqing Yu</a></span></p>
                <p> <span><a href="https://www.linkedin.com/in/xiangyu-zhao/" style="color: black;">Xiangyu Zhao</a></span></p>
                <hr class="small">
                <p class="text-muted">Copyright &copy; SpringBoard</a></p>
            </div>
        </div>
    </div>
</footer>




<script src="http://cdn.bootcss.com/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')</script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script>

    jQuery(document).ready(function () {

        $(".rating-kv").rating();

    });

</script>

</body>
</html>

