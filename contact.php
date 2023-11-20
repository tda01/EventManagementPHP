<?php
    require_once "dbClasses/eventDBController.php";
    require_once "dbClasses/contactsDBController.php";
    require_once "eventPage.php";

    session_start();

    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

    } else {
        exit("ID-ul nu a fost primit");
    }

    $eventController = new eventDBController();
    $contactController = new contactsDBController();
    $contact = $contactController->getContactForEvent($id);
    $event = $eventController->getEvent($id);
    $style = "eventSpeakers.css";

    $content = '<div class="speakPage hero flex items-centre justify-between">
        <div class="left flex flex-1 justify-center">
            <p>Contact</p>
        </div>
    </div>
    <section class="about">
        <div class="container flex items-centre">
            <div class="right flex-1 contact">
                <h1><span>Managerul proiectului</span></h1>
                <p>'.htmlentities($contact[0]["firstName"])." ".htmlentities($contact[0]["lastName"]).'</p>
                <p>'.htmlentities($contact[0]["phoneNumber"]).'</p>
                <h1><span>Location</span></h1>
                <p>'.htmlentities($event[0]["location"]). '</p>
            </div>
        </div>
    </section>';

    $pageGenerator = new eventPage($event[0], $style, $content);
    $pageGenerator->displayPage();