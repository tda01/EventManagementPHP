<?php
    require_once "dbClasses/speakersDBController.php";
    require_once "dbClasses/activitiesDBController.php";
    require_once "dbClasses/eventDaysDBController.php";
    require_once "dbClasses/eventDBController.php";


    session_start();

if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["rol"])) {
    header("Location: /ProiectPHP/login.html");
    exit;
}

if ($_SESSION["rol"] != "admin") {
    header("Location: /ProiectPHP/controlPanel.php");
    exit;
}


    $activityController = new activitiesDBController();
    $speakerController = new speakersDBController();
    $daysController = new eventDaysDBController();
    $eventController = new eventDBController();
    $allSpeakers = $speakerController->getAllSpeakers();
    $allEvents = $eventController->getAllEvents();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Activities</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/controlPanel.css">
</head>

<body>

<div class="table">
    <div class="table-header">
        <p>Activities</p>
        <div>
            <button class="new-event" id="addSpeaker">+ New activity</button>
            <button class="new-event" id="backControlPanel">Back to Panel</button>
        </div>
    </div>
</div>

<div class="table-section">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Event ID</th>
            <th>Name</th>
            <th>Hour</th>
            <th>Speaker</th>
            <th>Day</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $activities = $activityController->getAllActivities();

        if (!empty($activities)) {
            foreach ($activities as $activity) {
                $speaker = $speakerController->getSpeaker($activity["speakerID"]);
                $day = $daysController->getEventDay($activity["dayID"]);
                echo "<tr>";
                echo "<td>".$activity["activityID"]."</td>";
                echo "<td>".$day[0]["eventID"]."</td>";
                echo "<td>".$activity["name"]."</td>";
                echo "<td>".$activity["hour"]."</td>";
                echo "<td>".$speaker[0]["firstName"]." ".$speaker[0]["lastName"]."</td>";
                echo "<td>".$day[0]["day"]."</td>";
                echo '<td>
                           <a href="CRUD/edit/editActivity.php?id=' . $activity["activityID"] . '"><button class="edit-button"><i class="edit-button fa-solid fa-pen-to-square"></i></button></a>
                           <a href="CRUD/delete/deleteActivity.php?id='. $activity["activityID"].'"><button class="delete-button"><i class="fa-solid fa-trash"></i></button></a>
                    </td>';
                echo "</tr>";
            }
        }
        ?>

        </tbody>
    </table>
</div>

<div class="popup" id="addPopup">
    <form action="CRUD/insert/insertActivity.php" method="post">
        <button class="closeBtn" id="closePopup">&times;</button>
        <h2>Add New Activity</h2>
        <div>
            <label>Activity name</label>
            <input type="text" name="name" required/>
        </div>
        <div>
            <label>Hour</label>
            <input type="time" name="hour" required/>
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
        <button type="submit" id="addBtn">Add Activity</button>
    </form>
</div>

<script src="js/activities.js"></script>
</body>
</html>