<?php 
    require 'connection.php';
    require 'function.php';
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    }
?>

