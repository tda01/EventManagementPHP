<?php
require_once('../../dbClasses/activitiesDBController.php');
session_start();



if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["rol"])) {
    header("Location: /ProiectPHP/login.html");
    exit;
}

if ($_SESSION["rol"] != "admin") {
    header("Location: /ProiectPHP/login.html");
    exit;
}


if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    $activityController = new activitiesDBController();
    $activityController->deleteActivity($id);
    header("Location: /ProiectPHP/activities.php");
}