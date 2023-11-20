<?php
    require_once "dbClasses/eventDBController.php";
    require_once "dbClasses/speakersDBController.php";
    require_once "dbClasses/eventDaysDBController.php";
    require_once "eventPage.php";

    session_start();

    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

    } else {
        exit("ID-ul nu a fost primit");
    }

    $eventController = new eventDBController();
    $speakerController = new speakersDBController();
    $daysController = new eventDaysDBController();
    $days = $daysController->getEventDays($id);

    $startDate = $days[0]["day"];
    $startDate = strtotime($startDate);
    $startDate = date("d - F Y", $startDate);

    for ($i = 1; $i < sizeof($days); $i++) {
        $endDate = $days[$i]["day"];
}

    $event = $eventController->getEvent($id);
    $style = "event.css";
    $daysString = $startDate;
    if (!empty($endDate)) {
        $endDate = strtotime($endDate);
        $endDate = date("d - F Y", $endDate);
        $daysString = $daysString." — ".$endDate;
    }

    $allSpeakers = $speakerController->getEventSpeakers($id);


    $content = '<div class="hero flex items-center justify-between">
        <div class="left flex flex-1 justify-center">
            <img src="' . htmlentities($event[0]["img"]) . '" alt="' . htmlentities( $event[0]["title"]) . '">
        </div>
        <div class="right flex-1">
            <h1>' . htmlentities($event[0]["title"]) . '<br></h1>
            <div>
                <button class="btn btn-secondary" id="btnTickets">Register</button>
            </div>
        </div>
    </div>
    <section class="about">
    <div class="container flex items-centre">
        <div class="right flex-1">
            <h1>About <span>Event</span></h1>
            <p>'. htmlentities($event[0]["description"]).'
            </p>
              <h1>Durata <span>Event</span></h1>
            <h2>'. $daysString .'</h2>
        </div>
    </div>
</section>
<section class="speakers">
    <div class="container">
        <h1 class="speakers-head">Featured Speakers</h1>
        <div class="card-grid">';
    if (!empty($allSpeakers)) {
        $count = 0;
        foreach ($allSpeakers as $speaker) {
            if ($count < 3) {
                $content .= '<div class="card">
                <a href="#">
                    <img src="img/noimage.png">
                </a>
                <h2>'.htmlentities($speaker["firstName"])." ". htmlentities($speaker["lastName"]). '</h2>
                <p>'. htmlentities($speaker["occupation"]).'</p>
            </div>';
            }
            $count++;
        }
    }
     $content.= '</div>
        <div class="flex justify-center">
            <a href="eventSpeakers.php?id='.$id.'"><button class="btn btn-secondary btn-speakers" id="btnSpeakers">View All Speakers</button></a>
        </div>
    </div>
</section>
    ';


    $pageGenerator = new eventPage($event[0], $style, $content);
    $pageGenerator->displayPage();


