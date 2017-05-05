<?php  
    require 'connection.php';
    require 'function.php';
    session_start();
    $username = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SpringBoard</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <style type="text/css">
        .title{
            color: #FFFFFF;
        }

        .navbar-brand{
            font-size: 1.8em;
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
            <a class="navbar-brand" href="HomePage.php">SpringBorad</a>

        </div>

        <div class="collapse navbar-collapse">

            <ul class ="nav navbar-nav">
                <li class="active"><a href="HomePage.php">Home</a></li>
                <li><a href="explore.php">Explore</a></li>
                <li><a href ="fundrequest.php">Start a project</a></li>
            </ul>

            <?php 
              if (isset($username)) {
                  $query0 = $conn->prepare("SELECT Avatar FROM UserProfiles WHERE UID = ?");
                  $query0->bind_param("s", $username);
                  $query0->execute();
                  $query0->bind_result($icon);
                  $query0->fetch();
                  $query0->close();
                ?>

              <ul class="navbar-text navbar-right">
                  <!-- User icon -->
                  <?php 
                      if ($icon != null){
                          echo '<img src="' . $icon . '" class = "thumbnail user_icon" >';
                      }
                  ?>
                  <!-- Drop Down -->
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $username ?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="profile.php?userid=<?php echo $username; ?>">My Profile</a></li>
                      <li><a href="editProfile.php">Settings</a></li>
                      <li><a href="logout.php">Log Out</a></li>
                  </ul>

              </ul>

            <?php
              } else {//if not logged in

            ?>

            <form class ="navbar-form navbar-right" method="post" action="loginCheck.php">

                <div class="form-group">

                    <input type="text" class="form-control" placeholder="Username" name="loginname">
                    <input type="password" class="form-control" placeholder="*****" name="password">
                    <input type="submit" class="btn btn-success"  value="Log In">

                  </div>
                <button type ="button" class ="btn btn-danger" onclick="window.location.href='signup.php'">Sign Up</button>

            </form>
            <?php
                }
            ?>
           </div>
        </div>
    </div>
    <!-- Header -->
    <header id="top" class="header">
        <div class="text-vertical-center" style="color:white">
            <h1>SpringBoard</h1>
            <h3>Let's help you to start your dream!</h3>
            <br>
            <a href="#about" class="btn btn-dark btn-lg">Find Out More</a>
        </div>
    </header>

    <!-- About -->
    <section id="about" class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>SpringBoard is the perfect place for your next project!</h2>
                    <p class="lead">

                        <a target="_blank" href="signup.php">Become a member today!</a></p>
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

                <h1 class="center title">Explore By Tags</h1>
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

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h4><strong>Powered by</strong>
                    </h4>
                    <p>Renqing Yu
                        <br>Xiangyu Zhao</p>
                <hr class="small">
                    <p class="text-muted">Copyright &copy; SpringBoard</a></p>
                </div>
            </div>
        </div>
        <a id="to-top" href="#top" class="btn btn-dark btn-lg"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
    </footer>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    
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