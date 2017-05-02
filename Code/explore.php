<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/4/28
 * Time: 下午12:08
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

    <title>Explore</title>

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
            #56a0b5;
            color: #B0D1FB
        }

        .navbar-brand{
            font-size: 1.8em;
        }

        #topContainer{
            background-image:url("images/yellowbackground.jpg");
            height: 500px;
            width:  1200px;
            background-size:cover;

        }

        #topRow{
            margin-top: 300px;
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

        .margintop{
            margin-top: 300px;

        }
        .marginBottom{
            margin-bottom: 300px;
        }

        .tagcontainer{
            height: 350px;
            width: 1200px;
            background:url("images/hometagbackground.jpg") center;
            color: white;
        }



        @import url(http://fonts.googleapis.com/css?family=Lato:100,300,400,700);
        @import url(https://raw.github.com/FortAwesome/Font-Awesome/master/docs/assets/css/font-awesome.min.css);

        body {
            background: #DDD;
            font-size: 15px;
        }
        #wrap {
            margin: 50px 100px;
            display: inline-block;
            position: relative;
            height: 60px;
            float: right;
            padding: 0;
            position: relative;
        }


        #search {
            height: 60px;
            font-size: 55px;
            display: inline-block;
            font-family: "Lato";
            font-weight: 100;
            border: none;
            outline: none;
            color: #555;
            padding: 3px;
            padding-right: 60px;
            width: 0px;
            position: absolute;
            top: 0;
            right: 0;
            background: none;
            z-index: 3;
            transition: width .4s cubic-bezier(0.000, 0.795, 0.000, 1.000);
            cursor: pointer;
        }

        #search:focus:hover {
            border-bottom: 1px solid #BBB;
        }

        #search:focus {
            width: 700px;
            z-index: 1;
            border-bottom: 1px solid #BBB;
            cursor: text;
        }
        #search_submit {
            height: 67px;
            width: 63px;
            display: inline-block;
            color:red;
            float: right;
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAADNQTFRFU1NT9fX1lJSUXl5e1dXVfn5+c3Nz6urqv7+/tLS0iYmJqampn5+fysrK39/faWlp////Vi4ZywAAABF0Uk5T/////////////////////wAlrZliAAABLklEQVR42rSWWRbDIAhFHeOUtN3/ags1zaA4cHrKZ8JFRHwoXkwTvwGP1Qo0bYObAPwiLmbNAHBWFBZlD9j0JxflDViIObNHG/Do8PRHTJk0TezAhv7qloK0JJEBh+F8+U/hopIELOWfiZUCDOZD1RADOQKA75oq4cvVkcT+OdHnqqpQCITWAjnWVgGQUWz12lJuGwGoaWgBKzRVBcCypgUkOAoWgBX/L0CmxN40u6xwcIJ1cOzWYDffp3axsQOyvdkXiH9FKRFwPRHYZUaXMgPLeiW7QhbDRciyLXJaKheCuLbiVoqx1DVRyH26yb0hsuoOFEPsoz+BVE0MRlZNjGZcRQyHYkmMp2hBTIzdkzCTc/pLqOnBrk7/yZdAOq/q5NPBH1f7x7fGP4C3AAMAQrhzX9zhcGsAAAAASUVORK5CYII=) center center no-repeat;
            text-indent: -10000px;
            border: none;
            position: absolute;
            top: 0;
            right: 0;
            z-index: 2;
            cursor: pointer;
            opacity: 0.4;
            cursor: pointer;
            transition: opacity .4s ease;
        }

        #search_submit:hover {
            opacity: 0.8;
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
                <li><a href="homepage.php">Home</a></li>
                <li class="active"><a href="explore.php">Explore</a></li>
                <li><a href ="fundrequest.php">Start a project</a></li>
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

        <div class="col-md-6 col-md-offset-5" id="topRow">


            <div id="wrap" class="sss center">
                <form action="search.php" autocomplete="on">
                    <input id="search" name="search" type="text" placeholder="What're you looking for ?">
                    <input id="search_submit" value="Rechercher" type="submit">
                </form>
            </div>

            <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/>

        </div>

            <div class="center col-md-6 col-md-offset-3">
                <h3 class="center title">Try Tags :)</h3>
                <br/>

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