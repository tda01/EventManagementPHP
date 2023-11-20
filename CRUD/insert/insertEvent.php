<?php
require_once('../../dbClasses/eventDBController.php');
require_once ('../../dbClasses/ticketsDBController.php');
require_once ('../../dbClasses/contactsDBController.php');
require_once ('../../dbClasses/speakersDBController.php');
require_once ('../../dbClasses/collaboratorsDBController.php');
require_once ('../../dbClasses/eventDaysDBController.php');
require_once ('../../dbClasses/usersDBController.php');

use PHPMailer\PHPMailer\PHPMailer;

require '../../phpMailer/src/Exception.php';
require '../../phpMailer/src/PHPMailer.php';
require '../../phpMailer/src/SMTP.php';


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

    // Send mail to users


    $mail = new PHPMailer(true);
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vlad.12.moise.3@gmail.com';
        $mail->Password   = 'ybcgjskmfdciewkm';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('vlad.12.moise.3@gmail.com');

        //Content
        $mail->isHTML(true);
        $subiect = 'Invitatie eveniment '.$title;
        $mail->Subject = $subiect;
        $mail->Body    = '<h1>Esti invitat la eveniment!</h1>';
        $mail->AltBody = 'Invitatie eveniment';

        $userController = new usersDBController();
        $userMails = $userController->getUserMails();

        if(!empty($userMails)) {
            foreach ($userMails as $email) {
                $mailToSend = $email["email"];
                $mail->addAddress($mailToSend);
                $mail->send();
            }
        }



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
        $startDateObject = new DateTime($startDate);
        $endDateObject = new DateTime($endDate);

        if ($startDateObject > $endDateObject) {
            exit("Data nu este introdusa corect");
        }

        $dateRange = [];
        $currentDate = clone $startDateObject;
        while ($currentDate <= $endDateObject) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
        }
        foreach ($dateRange as $day) {
            $daysController->insertEventDay($day, $lastInsertedEventID);
        }
    } else {
        $date = $startDate;
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