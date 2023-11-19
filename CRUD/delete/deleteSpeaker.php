<?php
require_once('../../dbClasses/speakersDBController.php');
session_start();



if (!isset($_SESSION["loggedin"])) {
    header("Location: /ProiectPHP/login.html");
    exit;
}

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    $speakersController = new speakersDBController();
    $speakersController->deleteSpeaker($id);
    header("Location: /ProiectPHP/collaborators.php");
}