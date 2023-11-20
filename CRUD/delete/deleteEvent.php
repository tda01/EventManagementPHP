<?php
require_once('../../dbClasses/eventDBController.php');
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
    $eventController = new eventDBController();
    $eventController->deleteEvent($id);
    header("Location: /ProiectPHP/controlPanel.php");
} else {
    exit("ID-ul nu a fost primit");
}