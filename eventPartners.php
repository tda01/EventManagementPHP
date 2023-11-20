<?php
require_once "dbClasses/eventDBController.php";
require_once "dbClasses/collaboratorsDBController.php";
require_once "eventPage.php";

session_start();

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];

} else {
    exit("ID-ul nu a fost primit");
}

$eventController = new eventDBController();
$collaboratorController = new collaboratorsDBController();
$event = $eventController->getEvent($id);
$style = "eventSpeakers.css";

$content = '<div class="speakPage hero flex items-centre justify-between">
    <div class="left flex flex-1 justify-center">
        <p>Partners</p>
    </div>
</div>
<section>
    <div class="gallery flex justify-center">';

$allCollaborators = $collaboratorController->getEventCollaborators($id);

if (!empty($allCollaborators)) {
    foreach($allCollaborators as $collaborator) {
        $content .= '        <div class="img-box">
            <a href="#">
                <img src="img/noimage.png" alt="'.htmlentities($collaborator["name"]). '" />
            </a>
            <div class="transparent-box">
                <div class="caption">
                    <a href="'.htmlentities($collaborator["website"]). '"><p>'.htmlentities($collaborator["name"]). '</p></a>
                    <p class="opacity-low">'. htmlentities($collaborator["type"]).'</p>
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
