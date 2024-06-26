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



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = htmlentities($_POST["firstName"], ENT_QUOTES);
    $lastName = htmlentities($_POST['lastName'], ENT_QUOTES);
    $email = htmlentities($_POST['email'], ENT_QUOTES);
    $occupation = htmlentities($_POST['occupation'], ENT_QUOTES);
    $description = htmlentities($_POST['description'], ENT_QUOTES);
    $img = htmlentities($_POST['img'], ENT_QUOTES);

    if ($firstName == "" || $lastName == "" || $email == "" || $occupation == "" ||
    $description == "" || $img == "") {
        exit("Campurile sunt goale");
    }
    else {
        $speakersController = new speakersDBController();
        $speakersController->insertSpeaker($firstName, $lastName, $description, $occupation, $email, $img);
        header("Location: /ProiectPHP/speakers.php");
    }



}