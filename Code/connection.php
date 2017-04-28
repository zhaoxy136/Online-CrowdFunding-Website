<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/4/24
 * Time: 下午9:01
 */


//Connect to MySQL

    $conn = mysqli_connect("localhost","root","root","CrowdFund");
    //Test Connection
    if(mysqli_connect_errno()){
        echo 'Failed to connect to MySQL: '.mysqli_connect_error();
    }

