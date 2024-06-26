<?php
require_once('../../dbClasses/collaboratorsDBController.php');
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
    $collaboratorController = new collaboratorsDBController();
    $collaboratorController->deleteCollaborator($id);
    header("Location: /ProiectPHP/speakers.php");
} else {
    exit("ID-ul nu a fost primit");
}