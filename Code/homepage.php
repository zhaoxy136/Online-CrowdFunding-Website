<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/4/25
 * Time: 下午6:20
 */
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
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>名字真的还没起好</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>

        .title{
            color: #FFFFFF;
        }

        .navbar-brand{
            font-size: 1.8em;
        }

        #topContainer{
            background-image:url("images/homebackground.jpg");
            height: 700px;
            width:1200px;
            background-size:cover;

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

        .title{
            margin-top: 100px;
            font-size: 300%;
        }

        #footer {
            background-color: #B0D1FB;
        }

        .marginBottom{
            margin-bottom: 30px;
        }

        .tagcontainer{
            height: 350px;
            width: 1200px;
            background:url("images/hometagbackground.jpg") center;
            color: white;
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
            <a class="navbar-brand">Crowd Funding</a>

        </div>

        <div class="collapse navbar-collapse">

            <ul class ="nav navbar-nav">
                <li class="active"><a href="homepage.php">Home</a></li>
                <li><a href="#记得改">Explore</a></li>
                <li><a href ="#记得改">Start a project</a></li>
            </ul>

            <form class="navbar-form navbar-right" action="timeline.php" method="post">

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Username" name="loginname"/>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="*****" name="loginpassword"/>
                    </div>
                    <input type="submit" class="btn btn-success" name="submit" value="Log in"/>

                <button type="button" class ="btn btn-danger" onclick="window.location.href='signup.php'">Sign Up</button>

            </form>



        </div>
    </div>
</div>

<div class="container contentContainer" id="topContainer">

    <div class="row">

        <div class="col-md-6 col-md-offset-3" id="topRow">

            <h1 class="marginTop">名字还没起好</h1>

            <p class="lead">Now it's time for starting your own dream.</p>

            <p>Little More Detials</p>


            <a class="btn btn-info btn-xs" href="signup.php" role="button">Go</a>


            <form class="marginTop">


            </form>

        </div>

    </div>

</div>


<div class="container contentContainer">

    <div class="row center">

        <br/>
        <h1 class="center">Trending Projects</h1>
        <p class="lead center">Explore the fantastic ideas with the most sponsorships.</p>
        <hr>
    </div>

    <div class="row marginBottom">


        <?php
        $i=0;
        $j=0;
        ?>

        <div class="col-md-4 marginTop">

            <h2><span class="glyphicon glyphicon-music"></span>
                <?php
                $pnameforp = "";

                $res = TrendingProjName($conn,$i);
                while($row = mysqli_fetch_array($res)) {
                    echo $row['ProjName'];
                    $pnameforp = $row['ProjName'];
                    $i++;
                }
                ?></h2>

            <?php

            $res = TrendingProjDescription($conn,$j);
            while($row = mysqli_fetch_array($res)) {
                echo $row['Description'];
                $j++;
            }
            ?>
            <br/><br/>


            <?php

            echo "<a href='project.php?projectname=$pnameforp'><button class='btn btn-success marginTop'>Check it out!</button></a>";

            ?>

        </div>

        <div class="col-md-4 marginTop">

            <h2><span class="glyphicon glyphicon-star"></span>
                <?php

                $pnameforp = "";

                $res = TrendingProjName($conn,$i);
                while($row = mysqli_fetch_array($res)) {
                    echo $row['ProjName'];
                    $pnameforp = $row['ProjName'];
                    $i++;
                }
                ?></h2>

            <?php

            $res = TrendingProjDescription($conn,$j);
            while($row = mysqli_fetch_array($res)) {
                echo $row['Description'];
                $j++;
            }
            ?>
            <br/><br/>

            <?php

            echo "<a href='project.php?projectname=$pnameforp'><button class='btn btn-success marginTop'>Check it out!</button></a>";

            ?>

        </div>

        <div class="col-md-4 marginTop">


            <h2><span class="glyphicon glyphicon-heart"></span>
                <?php

                $pnameforp = "";

                $res = TrendingProjName($conn,$i);
                while($row = mysqli_fetch_array($res)) {
                    echo $row['ProjName'];
                    $pnameforp = $row['ProjName'];
                    $i++;
                }


                ?></h2>

                <?php

                $res = TrendingProjDescription($conn,$j);
                while($row = mysqli_fetch_array($res)) {
                    echo $row['Description'];
                    $j++;
                }
                ?>
            <br/><br/>


            <?php
            /*<button class="btn btn-success marginTop"><a  href="project.php?projectname=$pnameforp">Check it out!</a></button>
                <button  onclick="window.location.href='project.php?projectname=$pnameforp'"
                             class="btn btn-success marginTop">Check it out!</button>
                */
            echo "<a href='project.php?projectname=$pnameforp'><button class='btn btn-success marginTop'>Check it out!</button></a>";



            ?>


        </div>
    </div>

    <hr>

    <div class="container tagcontainer" id="footer">

        <div class="row">

            <h1 class="center title">Explore By Tags</h1>
            <br/>


            <div class="center">

            <a class="btn btn-warning btn-xs" href="" role="button">Art</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Books</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Comedy</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Culture</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Dance</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Drama</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Education</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Entertainment</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Fashion</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Fitness</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Food</a>
                <br/> <br/>
            <a class="btn btn-warning btn-xs" href="" role="button">Games</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Hiphop</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Jazz</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Life</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Movie</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Music</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Mystery</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Photography</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Pop</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Rock</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Sci-Fi</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Show</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Technology</a>
            <a class="btn btn-warning btn-xs" href="" role="button">Travel</a>

            </div>
        </div>
    </div>

            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="js/bootstrap.min.js"></script>

            <script>

                $(".contentContainer").css("min-height",$(window).height());

            </script>



</body>
</html>