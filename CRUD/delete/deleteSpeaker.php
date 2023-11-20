<?php
require_once('../../dbClasses/speakersDBController.php');
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
    $speakersController = new speakersDBController();
    $speakersController->deleteSpeaker($id);
    header("Location: /ProiectPHP/collaborators.php");
} else {
    exit("ID-ul nu a fost primit");
}