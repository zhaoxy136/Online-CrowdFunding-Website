<?php 
    require 'connection.php';
    require 'function.php';
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      	$loginname = test_input($_POST['loginname']);
        $password = test_input($_POST['password']);

        $logincheck = $conn->prepare("SELECT Passcode FROM Accounts WHERE UID = '$loginname'");
        $logincheck->execute();
        $logincheck->bind_result($hashed_passcode);
        $logincheck->fetch();
        $logincheck->close();
        
        if(!password_verify($password, $hashed_passcode)) {
            echo "<script>alert('Your Username or password is incorrect!')</script>";
        } else {
            //login success
            $_SESSION['loginuser'] = $_POST['loginname'];
        }
        echo "<script>location.href='homepage.php'</script>";


         
    }
?>

