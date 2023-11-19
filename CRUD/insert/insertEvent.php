<?php
require_once('../../dbClasses/eventDBController.php');
require_once ('../../dbClasses/ticketsDBController.php');
require_once ('../../dbClasses/contactsDBController.php');
require_once ('../../dbClasses/speakersDBController.php');
require_once ('../../dbClasses/collaboratorsDBController.php');
require_once ('../../dbClasses/eventDaysDBController.php');

session_start();

if (!isset($_SESSION["loggedin"])) {
    header("Location: /ProiectPHP/login.html");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Events

    $title = htmlentities($_POST["title"], ENT_QUOTES);
    $location = htmlentities($_POST["location"], ENT_QUOTES);
    $description = htmlentities($_POST["description"], ENT_QUOTES);
    $img = htmlentities($_POST["img"], ENT_QUOTES);

    if ($title == "" || $location == "" || $description == "" || $img == "") {
        exit("Campurile sunt goale");
    }

    $eventController = new eventDBController();
    $eventController->insertEvent($title, $location, $description, $img);
    $lastInsertedEvent = $eventController->getLastInsertedEvent();
    $lastInsertedEventID = $lastInsertedEvent[0]["eventID"];


    // Event days

    if (!empty($_POST["dateStart"])) {
        $startDate = $_POST["dateStart"];
    } else {
        exit ("Data nu este completata");
    }

    if (!empty($_POST["dateEnd"])) {
        $endDate = $_POST["dateEnd"];
    }



    $daysController = new eventDaysDBController();

    if (!empty($endDate)) {
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);
        $dateRange = [];
        while ($startDate <= $endDate) {
            $dateRange[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }
        foreach($dateRange as $day) {
            $daysController->insertEventDay($day, $lastInsertedEventID);
        }
    } else {
        $date = $startDate->format('Y-m-d');
        $daysController->insertEventDay($date, $lastInsertedEventID);
    }

    // Tickets

    $ticketPrice = htmlentities($_POST["ticketPrice"]);
    $ticketDescription = htmlentities($_POST["ticketDescription"]);

    if ($ticketPrice == "" || $ticketDescription == "") {
        exit("Campurile sunt goale");
    }
    $ticketController = new ticketsDBController();
    $ticketController->insertTicketType($ticketDescription, $ticketPrice, $lastInsertedEventID);


    // Contact

    $contactFirstName = htmlentities($_POST["contactFirstName"]);
    $contactLasttName = htmlentities($_POST["contactLastName"]);
    $contactPhoneNumber = htmlentities($_POST["contactPhoneNumber"]);
    $contactEmail = htmlentities($_POST["contactEmail"]);

    if ($contactFirstName == "" || $contactLasttName == "" || $contactPhoneNumber == "" || $contactEmail == "") {
        exit("Campurile sunt goale");
    }

    $contactController = new contactsDBController();
    $contactController->insertContact($contactFirstName, $contactLasttName, $contactPhoneNumber, $contactEmail, $lastInsertedEventID);

    // Speakers

    if (!empty($_POST["speakers"])) {
        $speakers = $_POST["speakers"];
        $speakerController = new speakersDBController();
        foreach ($speakers as $speaker) {
            $speakerController->insertEventSpeaker($lastInsertedEventID, $speaker);
        }
    }

    // Collaborators

    if (!empty($_POST["collaborators"])) {
        $collaborators = $_POST["collaborators"];
        $collaboratorController = new collaboratorsDBController();
        foreach ($collaborators as $collaborator) {
            $collaboratorController->insertEventCollaborator($lastInsertedEventID, $collaborator);
        }
    }

    header("Location: /ProiectPHP/controlPanel.php");

}