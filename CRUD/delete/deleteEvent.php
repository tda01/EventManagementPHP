<?php
require_once('../../dbClasses/eventDBController.php');
session_start();



if (!isset($_SESSION["loggedin"])) {
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