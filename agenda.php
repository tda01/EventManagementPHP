<?php

    require_once "dbClasses/eventDBController.php";
    require_once "dbClasses/speakersDBController.php";
    require_once "dbClasses/eventDaysDBController.php";
    require_once "dbClasses/activitiesDBController.php";
    require_once "eventPage.php";

    session_start();

    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

    } else {
        exit("ID-ul nu a fost primit");
    }


    $daysController = new eventDaysDBController();
    $activityController = new activitiesDBController();
    $eventController = new eventDBController();
    $speakersController = new speakersDBController();

    $days = $daysController->getEventDays($id);

    $content = '<div class="speakPage hero flex items-centre justify-between">
    <div class="left flex flex-1 justify-center">
        <p>Agenda</p>
    </div>
</div><section class="flex items-centre justify-center">';

    if (!empty($days)) {
        $dayCount = 1;
        foreach ($days as $day) {
            $content .= '    <div class="timeline-day">
        <h1>'."Day " . $dayCount. '</h1></div>
    <div class="timeline">';
            $activities = $activityController->getActivitiesForDay($day["eventDayID"]);
            if (!empty($activities)) {
                foreach($activities as $activity) {
                    $datetime = DateTime::createFromFormat('H:i:s', $activity["hour"]);
                    $formattedTime = $datetime->format('g:i A');
                    $speaker = $speakersController->getSpeaker($activity["speakerID"]);

                    $content .= ' <div class="timeline-entry">
            <div class="timeline-title">
                <h3>'. $formattedTime. '</h3>
            </div>
            <div class="timeline-body">
                <p>'. htmlentities($activity["name"]) .' </p>
                <ul>
                    <li>'.$speaker[0]["firstName"]. " " . $speaker[0]["lastName"]. '</li>
                </ul>
            </div>
        </div>';
                }
            } else {
                $content .= ' <div class="timeline-entry">
            <div class="timeline-title">
                
            </div>
            <div class="timeline-body">
                <p>Nu exista program pentru acesasta zi</p>
                <ul>
                </ul>
            </div>
        </div>';
            }
            $content .= '</div>';
            $dayCount += 1;
        }
    } else {
        $content .= '<p>Nu exista program pentru acest eveniment</p>';
    }

    $content .= '</section>';

    $event = $eventController->getEvent($id);
    $style = "eventAgenda.css";
    $keywordsContent = $event[0]["title"];
    $keywords = '<meta name="keywords" content="'. $keywordsContent. '">';
    $pageGenerator = new eventPage($event[0], $style, $content, $keywords);
    $pageGenerator->displayPage();