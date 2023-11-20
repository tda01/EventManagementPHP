<?php
    require_once "dbClasses/eventDBController.php";
    require_once "dbClasses/speakersDBController.php";
    require_once "eventPage.php";

    session_start();

    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

    } else {
        exit("ID-ul nu a fost primit");
    }

    $eventController = new eventDBController();
    $speakerController = new speakersDBController();
    $event = $eventController->getEvent($id);
    $style = "eventSpeakers.css";

    $content = '<div class="speakPage hero flex items-centre justify-between">
    <div class="left flex flex-1 justify-center">
        <p>Speakers</p>
    </div>
</div>
<section>
    <div class="gallery flex justify-center">';

    $allSpeakers = $speakerController->getEventSpeakers($id);

    if (!empty($allSpeakers)) {
        foreach($allSpeakers as $speaker) {
            $content .= '        <div class="img-box">
            <a href="#">
                <img src="img/noimage.png" alt="'.htmlentities($speaker["firstName"])." ". htmlentities($speaker["lastName"]). '" />
            </a>
            <div class="transparent-box">
                <div class="caption">
                    <p>'.htmlentities($speaker["firstName"])." ". htmlentities($speaker["lastName"]). '</p>
                    <p class="opacity-low">'. htmlentities($speaker["occupation"]).'</p>
                </div>
            </div>
        </div>';
        }
    }

    $content .= '    </div>
</section>';

    $keywordsContent = $event[0]["title"];
    $keywords = '<meta name="keywords" content="'. $keywordsContent. '">';
    $pageGenerator = new eventPage($event[0], $style, $content, $keywords);
    $pageGenerator->displayPage();
