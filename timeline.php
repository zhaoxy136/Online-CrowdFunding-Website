<?php
  require 'connection.php';
  session_start();
  $loginuser = $_SESSION['loginuser'];
  if (!isset($loginuser)) {
      echo "<script>alert('Please Log in First!')</script>";
      echo "<script>location.href='homepage.php'</script>";
  }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>What's Happening</title>
    <link href="css/timeline.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      .navbar-brand {
        font-size: 1.8em;
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
            <a class="navbar-brand" href="homepage.php">SpringBoard</a>

        </div>

        <div class="collapse navbar-collapse">

            <ul class ="nav navbar-nav">
                <li><a href="homepage.php">Home</a></li>
                <li class="active"><a href="explore.php">Explore</a></li>
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
                  <li><a href="profile.php?userid=<?php echo $loginuser;?>">My Profile</a></li>
                  <li><a href="editProfile.php">Settings</a></li>
                  <li><a href="logout.php">Log Out</a></li>
                </ul>

            </ul>
          </div>
      </div>
    </div>

  <header class="site-header">
    <div class="wrapper">
      <h1 class="site-header__title" style="margin-top: 100px;">See What's Happening</h1>
    </div>
  </header>

  <?php

    $query0 = $conn->prepare("SELECT UID, ProjName, HappenTime, ActiContent, ActiType FROM Following natural join Activities WHERE FollowerID = '$loginuser' ORDER BY HappenTime DESC");
    $query0->execute();
    $query0->bind_result($id, $proj, $happen, $detail, $type);
    $i = 0;
    ?>

  <div class="timeline">
    <div class="wrapper">
    <?php
    while ($query0->fetch()) {
      ?>
      <div class="timeline__item timeline__item--<?php echo $i;?>">
        <div class="timeline__item__station"></div>
        <div class="timeline__item__content">
          <h2 class="timeline__item__content__date"><?php echo date("M.d H:i", strtotime($happen));?></h2>

          <p class="timeline__item__content__description">
            <strong><em><a href="profile.php?userid=<?php echo $id;?>">
              <?php echo $id;?></a></em></strong>
          <?php if ($type == "post") { ?>
          posted a new project: 
          <?php } elseif ($type == "like") { ?>
          liked project:
          <?php } elseif ($type == "review") { ?>
          reviewd a completed project:
          <?php } elseif ($type == "comment") { ?>
          posted a comment on:
          <?php } elseif ($type == "update") { ?>
          had some new updates for 
          <?php } elseif ($type == "complete") { ?>
          completed the project:
          <?php } elseif ($type == "ongoing") { ?>
          started on the project:
          <?php } elseif ($type == "pledge") { ?>
          pledged on the project:
          <?php } ?>
          <strong><em><a href="project.php?projectname=<?php echo $proj;?>">
              <?php echo $proj;?></a></em></strong></p>
          <div class="timeline__item__content__detail">
            <?php
              if ($type == "post" || $type == "comment" || $type == "review" || $type == "ongoing" || $type == "complete") {
                  echo '"' .$detail .'"';
              }
            ?>
          </div>
        </div>
      </div>
    <?php
      $i++;
    }
    $query0->close();
    ?>
            
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js'></script>
  <script>
    function customWayPoint(className, addClassName, customOffset) {
    var waypoints = $(className).waypoint({
      handler: function(direction) {
        if (direction == "down") {
          $(className).addClass(addClassName);
        } else {
          $(className).removeClass(addClassName);
        }
      },
      offset: customOffset
    });
  }
  var defaultOffset = '50%';

  for (i=0; i<1000; i++) {
    customWayPoint('.timeline__item--'+i, 'timeline__item-bg', defaultOffset);
  }
  </script>

</body>

</html>