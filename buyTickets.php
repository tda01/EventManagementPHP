<?php

require_once "dbClasses/ticketsDBController.php";

session_start();

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];

} else {
    exit("ID-ul nu a fost primit");
}

if (!isset($_SESSION["loggedin"])) {
    header("Location: login.html");
    exit;
}

if (!isset($_SESSION["email"])) {
    exit ("Lipseste emailul");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST["buyerFirstName"]) && !empty($_POST["buyerLastName"]) && !empty($_POST["numberOfTickets"])) {
        if ($_POST["buyerLastName"] == "" || $_POST["buyerLastName"] == "" || $_POST["numberOfTickets"] == "") {
            exit ("Lispesc datele din formular");
        } else {
            $buyerFirstName = $_POST["buyerFirstName"];
            $buyerLastName = $_POST["buyerLastName"];
            $ticketCount = $_POST["numberOfTickets"];
            $ticketController = new ticketsDBController();
            $ticketType = $ticketController->getEventTicketTypes($id);
            $ticketID = $ticketType[0]["ticketID"];
            $buyerEmail = $_SESSION["email"];

            for ($i = 0; $i < $ticketCount; $i++) {
                $ticketController->sellTicket($buyerFirstName, $buyerLastName, $buyerEmail, $ticketID);
            }

            header("Location: home.php?id=".$id);

        }
    }


}