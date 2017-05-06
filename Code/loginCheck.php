<?php
session_start();
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST["loginname"])) {

        $loginname = $_POST['loginname'];
        $password = $_POST['password'];

        $query0 = $conn->prepare("SELECT * FROM Accounts WHERE UID = ? AND Passcode = ?");
        $query0->bind_param("ss", $loginname, $password);
        $query0->execute();
        $query0->bind_result($loginCheck, $passwordCheck);
        $query0->fetch();




        if(!isset($loginCheck)) {
            echo "<script>alert('Your Username or password is incorrect!')</script>";

        } else {
            //login success

            $_SESSION['loginuser'] = $loginCheck;
        }





        echo "<script>location.href='homepage.php'</script>";

        $query0->close();

    }
}


/*

$_SESSION['loginuser'] = $_POST['loginname'];

echo $_SESSION['loginuser'];
echo "<script>location.href='homepage.php'</script>";

*/




            /*
             *
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST["loginname"])) {

            $loginname = $_POST['loginname'];
            $password = $_POST['password'];
                   $loginname = test_input($_POST['loginname']);
                    $password = test_input($_POST['password']);


                      $login = $conn->prepare("SELECT UID FROM Accounts WHERE UID = ? AND Passcode = ?");
                         $login->bind_param("ss", $loginname, $password);
                         $login->execute();
                         $loginCheck = $login->get_result();


                          if($loginCheck->num_rows < 1) {
                             echo "<script>alert('Your Username or password is incorrect!')</script>";
                         } else {
                             //login success
                             $_SESSION['loginuser'] = $_POST['loginname'];
                         }
                         echo "<script>location.href='homepage.php'</script>";



            if(empty($loginname)) {

                echo "<script>alert('The username is empty :)')</script> ";


            }

     $query0 = $conn->prepare("SELECT * FROM Accounts WHERE UID = '$loginname' AND Passcode = '$password'");
     $query0 -> execute();
     $query0 -> bind_result($loginCheck, $passwordCheck);
     $query0 -> fetch();


     if(isset($loginCheck)){
         //login success
         $_SESSION['loginuser'] = $loginCheck;

         echo "$loginCheck";

         echo $_SESSION['loginuser'];



     }else {
         echo "<script>alert('Your Username or password is incorrect!')</script>";
     }



     $query0->close();

     echo $_SESSION['loginuser'];

     //echo "$loginCheck";
     //echo "$passwordCheck";

     echo "<script>location.href='homepage.php'</script>";

    }
    }


            */



