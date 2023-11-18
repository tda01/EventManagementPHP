<?php
require_once('../../dbClasses/collaboratorsDBController.php');
session_start();

if (!isset($_SESSION["loggedin"])) {
    header("Location: /ProiectPHP/login.html");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlentities($_POST["name"], ENT_QUOTES);
    $type = htmlentities($_POST['collaboratorType'], ENT_QUOTES);
    $email = htmlentities($_POST['email'], ENT_QUOTES);
    $phoneNumber = htmlentities($_POST['phoneNumber'], ENT_QUOTES);
    $website = htmlentities($_POST['website'], ENT_QUOTES);
    $img = htmlentities($_POST['img'], ENT_QUOTES);

    if ($name == "" || $type == "" || $email == "" || $phoneNumber == "" ||
        $website == "" || $img == "") {
        echo "Campurile sunt goale";
    }
    else {
        $collaboratorController = new collaboratorsDBController();
        $collaboratorController->insertCollaborator($name, $phoneNumber, $email, $website, $type, $img);
        header("Location: /ProiectPHP/collaborators.php");
    }



}