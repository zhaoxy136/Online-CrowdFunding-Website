<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/4/28
 * Time: 下午5:31
 */
include 'connection.php';
include 'function.php';
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



    <link rel="stylesheet" type="text/css" href="css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/component.css" />
    <link rel="stylesheet" type="text/css" href="css/cs-select.css" />
    <link rel="stylesheet" type="text/css" href="css/cs-skin-boxes.css" />

    <script src="js/modernizr.custom.js"></script>


    <style>


        .navbar-brand{
            font-size: 1.8em;
        }

        #topContainer{


        }

        #topRow h1 {
            font-size: 300%;

        }
        .center{
            text-align: center;
        }


        .form-control {
            display: block;
            width: 50%;
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
                <li><a href="explore.php">Explore</a></li>
                <li class="active"><a href ="fundrequest.php">Start a project</a></li>
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

<div class="fs-form-wrap" id="fs-form-wrap" style="margin-top: 50px;">
    <div class="fs-title">
        <h1>Start your own dream <br/>
            By post a funding request right now</h1>
    </div>
    <form id="myform" class="fs-form fs-form-full" autocomplete="off">
        <ol class="fs-fields">
            <li>
                <label class="fs-field-label fs-anim-upper" for="q1">What's Your Project Name?</label>
                <input class="fs-anim-lower" id="q1" name="q1" type="text" placeholder="Project Name" required/>
            </li>
            <li>
                <label class="fs-field-label fs-anim-upper" for="q2">Describe your project in 140 words</label>
                <textarea class="fs-anim-lower" id="q2" name="q2" placeholder="Describe here"></textarea>
            </li>
            <li>
                <label class="fs-field-label fs-anim-upper" for="q3">How much is your MINIMUM budget?</label>
                <input class="fs-mark fs-anim-lower" id="q3" name="q3" type="number" placeholder="1000" step="50" min="100"/>
            </li>
            <li>
                <label class="fs-field-label fs-anim-upper" for="q4">How much is your MAXIMUM expected value?</label>
                <input class="fs-mark fs-anim-lower" id="q4" name="q4" type="number" placeholder="5000" step="50" min="100"/>
            </li>

            <li data-input-trigger>
                <label class="fs-field-label fs-anim-upper" data-info="We'll make sure to use it all over">Select tags.</label>
                <select class="cs-select cs-skin-boxes fs-anim-lower">
                    <option value="" disabled selected>Pick a color</option>
                    <option value="#588c75" data-class="color-588c75">Art</option>
                    <option value="#b0c47f" data-class="color-b0c47f">Books</option>
                    <option value="#f3e395" data-class="color-f3e395">Comedy</option>
                    <option value="#f3ae73" data-class="color-f3ae73">Culture</option>
                    <option value="#da645a" data-class="color-da645a">Dance</option>
                    <option value="#79a38f" data-class="color-79a38f">Drama</option>
                    <option value="#c1d099" data-class="color-c1d099">Education</option>
                    <option value="#f5eaaa" data-class="color-f5eaaa">Entertainment</option>
                    <option value="#f5be8f" data-class="color-f5be8f">Fashion</option>
                    <option value="#e1837b" data-class="color-e1837b">Fitness</option>
                    <option value="#9bbaab" data-class="color-9bbaab">Food</option>
                    <option value="#d1dcb2" data-class="color-d1dcb2">Games</option>
                    <option value="#f9eec0" data-class="color-f9eec0">Life</option>
                    <option value="#f7cda9" data-class="color-f7cda9">Movie</option>
                    <option value="#e8a19b" data-class="color-e8a19b">Music</option>
                    <option value="#bdd1c8" data-class="color-bdd1c8">Photography</option>
                    <option value="#e1e7cd" data-class="color-e1e7cd">Sci-Fi</option>
                    <option value="#faf4d4" data-class="color-faf4d4">Show</option>
                    <option value="#fbdfc9" data-class="color-fbdfc9">Technology</option>
                    <option value="#f1c1bd" data-class="color-f1c1bd">Travel</option>
                </select>
            </li>


        </ol><!-- /fs-fields -->
        <button class="fs-submit" type="submit">Post Request :)</button>
    </form><!-- /fs-form -->
</div><!-- /fs-form-wrap -->




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