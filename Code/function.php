<?php
/**
 * Created by PhpStorm.
 * User: ft
 * Date: 2017/4/26
 * Time: 下午12:34
 */


function TrendingProjName($con,$i){
    $result = mysqli_query($con, "SELECT ProjName FROM Projects ORDER BY SponsorCount DESC LIMIT ".$i.",1");
    return $result;
}

function TrendingProjDescription($con,$i){
    $result = mysqli_query($con, "SELECT Description FROM Projects ORDER BY SponsorCount DESC LIMIT ".$i.",1");
    return $result;
}

function TrendingProj($con,$i){
    $result = mysqli_query($con, "SELECT ProjName, Description FROM Projects ORDER BY SponsorCount DESC LIMIT ".$i.",1");
    return $result;
}
