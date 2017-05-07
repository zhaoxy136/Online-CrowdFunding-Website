<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/5/1
 * Time: 下午1:05
 */

session_start();

require 'connection.php';
require 'function.php';

$loginuser = $_SESSION['loginuser'];
$clicktag = $_GET["clicktag"];

setcookie("taguser",$loginuser,time()+60*60*24*30);
setcookie("clctag",$_GET["clicktag"],time()+60*60*24*30);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Tag Results</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet" type="text/css">


    <style>
        .title{
            color: #FFFFFF;
        }

        .navbar-brand{
            font-size: 1.8em;
        }

        .center{
            text-align: center;
        }

        .title{
            margin-top: 100px;
            font-size: 300%;
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

<!-- Header -->
<header id="top" class="searchheader">
    <div class="text-vertical-center" >
        <h2>Tag: <?php echo $clicktag;?></h2>


        <br/>
        <?php

        $query1 = $conn->prepare(
            "SELECT p.ProjID, ProjName, PostTime
                    FROM Projects p natural join Label
                    WHERE tag = '$clicktag'
                    Order by PostTime desc");
        $query1 -> execute();
        $query1 -> bind_result($projid,$projname,$posttime);


        ?>

        <div class="container" style="margin-top: 5%;">

            <div class="col-md-12">
                <table class="table  table-hover">
                    <thead class="thead">
                    <tr>
                        <td> Project ID </td><td> Project Name </td><td> Post Time </td></tr>
                    </thead>
                    <tbody>
                    <?php
                    while($query1 -> fetch()){
                        echo "<tr>
                              <td><a href ='project.php?projectname=$projname'>$projid</a></td><td> $projname </td><td> $posttime </td>";
                        echo "</tr>\n";
                    }
                    $query1 -> close();
                    ?>
                    </tbody>

                </table>
            </div>
        </div>
        <br/>
        <a href="explore.php" class="btn btn-dark btn-xs">Back to Explore</a>

    </div>
</header>

<!-- About -->
<section id="about" class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Don't find any?</h2>
                <p class="lead">

                    <a target="_blank" href="fundrequest.php">Start Your Own</a></p>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Callout -->
<aside class="callout">
    <div class="text-vertical-center">

        <div class="row">

            <h1 class="center title">Try Tags :)</h1>
            <br/>


            <div class="center">

                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Art" role="button">Art</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Books" role="button">Books</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Comedy" role="button">Comedy</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Culture" role="button">Culture</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Dance" role="button">Dance</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Drama" role="button">Drama</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Education" role="button">Education</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Entertainment" role="button">Entertainment</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Fashion" role="button">Fashion</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Fitness" role="button">Fitness</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Food" role="button">Food</a>
                <br/> <br/>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Games" role="button">Games</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Hiphop" role="button">Hiphop</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Jazz" role="button">Jazz</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Life" role="button">Life</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Movie" role="button">Movie</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Music" role="button">Music</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Mystery" role="button">Mystery</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Photography" role="button">Photography</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Pop" role="button">Pop</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Rock" role="button">Rock</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Sci-Fi" role="button">Sci-Fi</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Show" role="button">Show</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Technology" role="button">Technology</a>
                <a class="btn btn-success btn-xs" href="tag.php?clicktag=Travel" role="button">Travel</a>

            </div>
        </div>
    </div>
</aside>





<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

<script>window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')</script>

    <script>

        $(".contentContainer").css("min-height",$(window).height());

        // Scrolls to the selected menu item on the page
        $(function() {
            $('a[href*=#]:not([href=#],[data-toggle],[data-target],[data-slide])').click(function() {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top
                        }, 1000);
                        return false;
                    }
                }
            });
        });
        //#to-top button appears after scrolling
        var fixed = false;
        $(document).scroll(function() {
            if ($(this).scrollTop() > 250) {
                if (!fixed) {
                    fixed = true;
                    // $('#to-top').css({position:'fixed', display:'block'});
                    $('#to-top').show("slow", function() {
                        $('#to-top').css({
                            position: 'fixed',
                            display: 'block'
                        });
                    });
                }
            } else {
                if (fixed) {
                    fixed = false;
                    $('#to-top').hide("slow", function() {
                        $('#to-top').css({
                            display: 'none'
                        });
                    });
                }
            }
        });


    </script>



</body>
</html>