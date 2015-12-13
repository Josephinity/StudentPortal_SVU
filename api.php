<?php

$student='A0229';// will get from session
$yearterm='201503';// will get from session
function getStudentRecord($token){
    $ch = curl_init();
    $postData="studentID=".$GLOBALS['student'] ."&token=".$token."&yearterm=".$GLOBALS['yearterm'];
    curl_setopt($ch, CURLOPT_URL, "http://connect.svuca.edu/services/registration/classes/studentRecord.php");
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $output = curl_exec($ch);
    curl_close($ch);
}


function geStudentClass($token){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://connect.svuca.edu/services/registration/student_class.php?studentID=".$GLOBALS['student']."&token=".$token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function addClass($token,$classId,$fee){
    $ch = curl_init();
    $url ="http://connect.svuca.edu/services/registration/classes/add_class.php";
    $postData="studentID=".$GLOBALS['student']."&token=".$token."&classID=".$classId."&yearterm=".$GLOBALS['yearterm']."&fee=".$fee;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


function dropClass($token,$classId){
    $ch = curl_init();
    $url ="http://connect.svuca.edu/services/registration/classes/drop_class.php";

    $postData="studentID=".$GLOBALS['student']."&token=".$token."&classID=".$classId."&yearterm=".$GLOBALS['yearterm'];
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


if (isset($_GET["action"]))
{
    switch ($_GET["action"])
    {
        case "addClass":
            $value = addClass( $_GET["token"], $_GET["classId"], $_GET["fee"]);
            exit($value);
            break;
        case "dropClass":
            $value = dropClass($_GET["token"], $_GET["classId"]);
            exit($value);
            break;

        case "getStudentRecord":
            $value = getStudentRecord( $_GET["token"]);
            break;
        case "getStudentClass":

            $value = geStudentClass($_GET["token"]);
            exit($value);
            break;

    }
}

//return JSON array
//exit(json_encode($value));
//exit(json_encode($value));
?>