<?php
require_once('../../dbClasses/activitiesDBController.php');
require_once('../../dbClasses/speakersDBController.php');
require_once('../../dbClasses/eventDBController.php');
require_once('../../dbClasses/eventDaysDBController.php');

session_start();

if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["rol"])) {
    header("Location: /ProiectPHP/login.html");
    exit;
}

if ($_SESSION["rol"] != "admin") {
    header("Location: /ProiectPHP/login.html");
    exit;
}


if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    $activityController = new activitiesDBController();
    $activity = $activityController->getActivity($id);
    $speakerController = new speakersDBController();
    $daysController = new eventDaysDBController();
    $eventController = new eventDBController();
    $allSpeakers = $speakerController->getAllSpeakers();
    $allEvents = $eventController->getAllEvents();
} else {
    exit("Id invalid");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlentities($_POST["name"], ENT_QUOTES);
    $hour = htmlentities($_POST['hour'], ENT_QUOTES);


    if (!empty($_POST["speakers"])) {
        $speaker = $_POST["speakers"];
        $speakerID = $speaker[0];
    } else {
        exit("Lipsesc speakeri");
    }

    if (!empty($_POST["days"])) {
        $day = $_POST["days"];
        $dayID = $day[0];
    } else {
        exit("Lipsesc zile");
    }

    if ($name == "" || $hour == "") {
        exit("Campurile sunt goale");
    }
    else {
        $activityController = new activitiesDBController();
        $activityController->updateActivity($id, $name, $hour, $speakerID, $dayID);
        header("Location: /ProiectPHP/activities.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Activities</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/css/controlPanel.css">
</head>

<body>

<div class="table">
    <div class="table-header">
        <p>Activities</p>
        <div>
            <button class="new-event" id="backControlPanel">Back to Panel</button>
        </div>
    </div>
</div>

<div class="popup" id="editPopup">
    <form action="" method="post">
        <h2>Edit Activity</h2>
        <div>
            <label>Activity name</label>
            <input type="text" name="name" value="<?php echo $activity[0]["name"]?>" required/>
        </div>
        <div>
            <label>Hour</label>
            <input type="time" name="hour" value="<?php echo $activity[0]["hour"]?>" required/>
        </div>
        <div>
            <label>Speaker</label>
            <select name="speakers[]" required>
                <option value="" disabled>Select an option</option>
                <?php
                if(!empty($allSpeakers)){
                    foreach ($allSpeakers as $speaker) {
                        echo '<option value="' . $speaker["speakerID"] . '">' . $speaker["firstName"] . " " . $speaker["lastName"] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div>
            <label>Event day</label>
            <select name="days[]">
                <option value="" disabled>Select an option</option>
                <?php
                if(!empty($allEvents)){
                    foreach ($allEvents as $event) {
                        $eventDays = $daysController->getEventDays($event["eventID"]);
                        foreach ($eventDays as $eventDay) {
                            echo '<option value="' . $eventDay["eventDayID"] . '">' . $event["title"]." - " . $eventDay["day"] . "</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>
        <button type="submit" id="addBtn">Edit activity</button>
    </form>
</div>

<script src="/js/editActivities.js"></script>
</body>
</html>