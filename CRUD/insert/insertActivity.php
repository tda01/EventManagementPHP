<?php
require_once('../../dbClasses/activitiesDBController.php');
session_start();

if (!isset($_SESSION["loggedin"])) {
    header("Location: /ProiectPHP/login.html");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlentities($_POST["name"], ENT_QUOTES);
    $hour = htmlentities($_POST['hour'], ENT_QUOTES);


    if (!empty($_POST["speakers"])) {
        $speaker = $_POST["speakers"];
        $speakerID = $speaker[0];
    } else {
        exit("Lipsesc speakeri");
    }

    if (!empty($_POST["days"])) {
        $day = $_POST["days"];
        $dayID = $day[0];
    } else {
        exit("Lipsesc zile");
    }

    if ($name == "" || $hour == "") {
        exit("Campurile sunt goale");
    }
    else {
        $activityController = new activitiesDBController();
        $activityController->insertActivity($name, $hour, $speakerID, $dayID);
        header("Location: /ProiectPHP/activities.php");
    }




}