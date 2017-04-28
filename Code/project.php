<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/4/27
 * Time: 下午2:12
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

    <title>项目</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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


    <div class="row center projmarginBottom" id="topRow">

        <br/>

        <?php

        $projectname = $_GET["projectname"];

        echo "<div><h1 class=\"center\">".$projectname. "</h1></div>";




        ?>



        <p class="lead center ">Proj descp</p>

    </div>

</div>

<div class="container contentContainer" id="midContainer">
    <hr>

    <div class="col-md-6 marginTop center">



            <h3><span class="glyphicon glyphicon-user"></span>
                <br/>Project Owner</h3>

                 <h3>Owner F&LName</h3>

        Owner email

        interest


    </div>

    <div class="col-md-6 marginTop">


        <div class="center">
        <h3>Project Status: From DB</h3>
        </div>

        <ul class = "list-group">

            <li class="list-group-item">
                <span class="glyphicon glyphicon-king"></span> Sponsor Count<span class="badge">4</span></li>
            <li class="list-group-item">
                <span class="glyphicon glyphicon-usd"></span> Already Fund<span class="badge">$2500</span></li>
            <li class="list-group-item">
                <span class="glyphicon glyphicon-thumbs-up"></span> Like Count<span class="badge">12</span></li>
            <li class="list-group-item">
                <span class="glyphicon glyphicon-fire"></span> Avg Rating<span class="badge">4.2</span></li>

    </div>


</div>



<div class="container contentContainer" id="btmContainer">

    <hr>

    <div class="center">
        <ul class ="nav">
            <li><a href="#记得改" class ="link">Updates</a></li>
            <li><a href ="#记得改" class ="link">Comments</a></li>
        </ul>
        <br/>
    </div>

    <div class="center">

        <a class="btn btn-success btn-lg" href="pledgepage.php" role="button">SPONSOR IT!</a>

    </div>



</div>












<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<script>



</script>



</body>
</html>




