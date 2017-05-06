<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/4/24
 * Time: 下午9:01
 */

date_default_timezone_set('America/New_York');
//Connect to MySQL

    $conn = mysqli_connect("localhost","root","root","CrowdFund");
    //Test Connection
    if(mysqli_connect_errno()){
        echo 'Failed to connect to MySQL: '.mysqli_connect_error();
    }

