<?php
session_start();
include 'connection.php';
include 'function.php';
$loginuser = $_SESSION['loginuser'];

$uidforp = $_GET['userid'];

$query0 = $conn->prepare(
    "SELECT *
            FROM UserProfiles
            WHERE UID = '$uidforp'");
$query0 -> execute();
$query0 -> bind_result($puid,$pfirstname,$plastname,$icon,$pgender,$pcity,$pstate,$pcellphone,
    $pemailaddress, $pcreditcardnumber, $pinterests);
$query0->fetch();
$query0->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['follow'])) {
        $subquery01 = $conn->prepare("INSERT INTO Following (UID, FollowerID) VALUES (?, ?)");
        $subquery01->bind_param("ss", $uidforp, $loginuser);
        $subquery01->execute();
        $subquery01->close();
    } elseif (isset($_POST['unfollow'])) {
        $subquery02 = $conn->prepare("DELETE FROM Following WHERE UID = '$uidforp' AND FollowerID = '$loginuser'");
        $subquery02->execute();
        $subquery02->close();
    }
}

?>


<!DOCTYPE HTML>
<html>
	<head>

		<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Profile Page</title>

		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        
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

            .marginBottom{
                margin-bottom: 30px;
            }

            .user_icon{
              margin: 0 5px;
              width: 20px;
              height: 20px;
              display: inline;
              padding: 0;
              border: 1px solid rgba(0,0,0,0);
            }

            .image img {
                max-width: 90px;
                max-height: 90px;
                min-height: 90px;
                min-width: 90px;
            }
            a{
                border-style: none;
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
                <li class="active"><a href="homepage.php">Home</a></li>
                <li><a href="explore.php">Explore</a></li>
                <li><a href ="fundrequest.php">Start a project</a></li>
            </ul>

            <?php
                if(isset($loginuser)) {
                    $query0 = $conn->prepare("SELECT Avatar FROM UserProfiles WHERE UID = ?");
                    $query0->bind_param("s", $loginuser);
                    $query0->execute();
                    $query0->bind_result($loginicon);
                    $query0->fetch();
                    $query0->close();
                ?>

              <ul class="navbar-text navbar-right dropdown">
                  <!-- User icon -->
                  <?php 
                      if ($loginicon != null){
                          echo '<img src="' . $loginicon . '" class = "thumbnail user_icon" >';
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


		<!-- Header -->
			<header id="header">
				<div class="inner">
                    <div class="image"><img src="<?php echo $icon;?>" onerror="this.src='images/defaulticon.jpg';"/></div>
                    <?php
                        echo "<h1><strong>$pfirstname $plastname</strong></h1><br/><br/>";
                        echo "<span class=\"glyphicon glyphicon-user\"></span> Gender: $pgender<br/>";
                        echo "<span class=\"glyphicon glyphicon-map-marker\"></span> Location: $pcity, $pstate<br/>";
                        echo "<span class=\"glyphicon glyphicon-cutlery\"></span> Interest: $pinterests<br/>";
                        echo "<span class=\"glyphicon glyphicon-envelope\"></span> Email: $pemailaddress<br/><br/><br/>";


                    if (isset($loginuser) && $loginuser != $uidforp) {
                    $query10 = $conn->prepare("SELECT * FROM Following WHERE UID = '$uidforp' AND FollowerID = '$loginuser'");
                    $query10->execute();
                    if ($query10->fetch()) {
                        //show unfollow btn
                        $query10->close();
                        ?>
                        <form method="post" action="profile.php?userid=<?php echo $uidforp;?>">
                        <input type="hidden" name="unfollow">
                        <button type="submit" class="btn btn-danger">Unfollow</button>
                        </form>
                    <?php } else { 
                        //show follow btn 
                        $query10->close();
                        ?>
                        <form method="post" action="profile.php?userid=<?php echo $uidforp;?>">
                        <input type="hidden" name="follow">
                        <button type="submit" class="btn btn-success">Follow</button>
                        </form>
                    <?php 
                        }
                    }
                    //$query10->close();
                    $query11 = $conn->prepare(
                        "SELECT count(*) as followingnum
                                FROM Following
                                WHERE FollowerID = '$uidforp'");
                    $query11 -> execute();
                    $query11 -> bind_result($followingnum);
                    $query11->fetch();

                    echo "Following: $followingnum";


                    $query11->close();

                    echo " / ";


                    $query12 = $conn->prepare(
                        "SELECT count(*) as followernum
                                FROM Following
                                WHERE UID = '$uidforp'");
                    $query12 -> execute();
                    $query12 -> bind_result($followernum);
                    $query12->fetch();

                    echo "Follower: $followernum";

                    $query12->close();



                    ?>

                    <br/>
                </div>
			</header>

		<!-- Main -->
			<div id="main">
				<!-- One -->
					<section id="one">

                    <?php

                        $query2 = $conn->prepare(
                        "SELECT *
                        FROM Projects
                        WHERE OwnerID = '$uidforp'");
                        $query2 -> execute();
                        $query2 -> bind_result($pprojid,$pprojname,$pdescription,$pownerid,$pminfundvalue,$pmaxfundvalue,$pposttime,
                        $pfundingendtime, $pstarttime, $ptargettime, $pcompletetime, $plikecount, $psponsorcount, $palreadyfund, $pstatus, $pavgrating);


                        echo " <header class=\"major\">
							<h2>Owned Projects</h2>
						        </header>
						        <div class=\"table-wrapper\">
						        <table class=\"table  table-hover\">
                                  <thead>
                                 <tr>
                               <td> Project Name </td><td> Post Time </td><td> Status </td></tr>
                             </thead>
                                <tbody>";

                        while($query2 -> fetch()){

                        echo "<tr>
                              <td><a href ='project.php?projectname=$pprojname'>$pprojname</a></td><td> $pposttime</td><td> $pstatus </td>";
                        echo "</tr>\n";
                    }

                        echo"
                         </tbody>
                         </table>
                         </div>";

                    if(!$pprojid){

                        echo "<h3><span style='text-align: center; color: #49bf9d; margin-left: 120px;'> Haven't requested any funding.</span></h3>";
                    }

                        $query2->close();


                    ?>

					</section>

				<!-- Two -->
					<section id="two">

                        <?php

                        $query3 = $conn->prepare(
                            "SELECT ProjID, ProjName, PledgeTime, Amount
                                    FROM Pledges NATURAL JOIN Projects 
                                    WHERE UID = '$uidforp'");
                        $query3 -> execute();
                        $query3 -> bind_result($pprojid,$projectname,$pledgetime,$amount);


                        echo " <header class=\"major\">
							<h2>Recent Sponsorships</h2>
						        </header>
						        <div class=\"table-wrapper\">
						        <table class=\"table  table-hover\">
                                  <thead>
                                 <tr>
                               <td> Sponsored Project </td><td> Pledged Time </td><td> Pledged Amount </td></tr>
                             </thead>
                                <tbody>";




                        while($query3 -> fetch()){

                            echo "<tr>
                              <td><a href ='project.php?projectname=$projectname'>$projectname</a></td><td> $pledgetime</td><td>$ $amount </td>";
                            echo "</tr>\n";
                        }

                        echo"
                         </tbody>
                         </table>
                         </div>";


                        if(!$pprojid){

                            echo "<h3><span style='text-align: center; color: #49bf9d; margin-left: 120px;'> Haven't backed any projects.</span></h3>";
                        }

                        $query3->close();


                        ?>

                    </section>

			</div>

		<!-- Footer -->
			<footer id="footer">
				<div class="inner">

					<ul class="copyright">
						<li>&copy;SpringBoard</li>
					</ul>
				</div>
			</footer>

		<!-- Scripts -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.js"></script>

			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>