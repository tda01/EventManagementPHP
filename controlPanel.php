<?php
    require_once "dbClasses/eventDBController.php";
    require_once "dbClasses/speakersDBController.php";
    require_once "dbClasses/collaboratorsDBController.php";

    session_start();

    if (!isset($_SESSION["loggedin"])) {
        header("Location: login.html");
        exit;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Control Panel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/controlPanel.css">
</head>

<body>

<!-- Page Header -->


<div class="table">
    <div class="table-header">
        <p>Events Details</p>
        <div>
            <button class="new-event" id="addEvent">+ New Event</button>
            <a href="speakers.php"><button class="new-event" id="addEvent">+ Add speakers</button></a>
            <a href="collaborators.php"><button class="new-event" id="addEvent">+ Add collaborators</button></a>
            <a href="logout.php"><button class="new-event" id="addEvent"> Logout</button></a>
        </div>
    </div>
</div>

<!-- Events Table -->
<div class="table-section">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Event</th>
            <th>Description</th>
            <th>Speakers</th>
            <th>Partners</th>
            <th>Location</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $eventsController = new eventDBController();
            $speakersController = new speakersDBController();
            $collaboratorsController = new collaboratorsDBController();
            $events = $eventsController->getAllEvents();

            foreach ($events as $event) {
                echo "<tr>";
                echo "<td>".$event["eventID"]."</td>";
                echo "<td>".$event["img"]."</td>";
                echo "<td>".$event["title"]."</td>";
                echo "<td>".$event["description"]."</td>";

                $speakers = $speakersController->getEventSpeakers($event["eventID"]);
                if (!empty($speakers)) {
                    echo "<td>";
                    foreach ($speakers as $speaker) {
                        echo $speaker["firstName"]." ".$speaker["lastName"];
                        echo "<br>";
                    }
                    echo "</td>";
                } else {
                    echo "<td>"."Nu exista"."</td>";
                }
                $collaborators = $collaboratorsController->getEventCollaborators($event["eventID"]);
                if (!empty($collaborators)) {
                    echo "<td>";
                    foreach ($collaborators as $collaborator) {
                        echo $collaborator["name"];
                        echo "<br>";
                    }
                    echo "</td>";
                } else {
                    echo "<td>"."Nu exista"."</td>";
                }


                echo "<td>".$event["location"]."</td>";
                echo '<td>
                           <button class="edit-button"><i class="fa-solid fa-pen-to-square"></i></button>
                           <button class="delete-button"><i class="fa-solid fa-trash"></i></button>
                    </td>';
                echo "</tr>";
            }

        ?>

        </tbody>
    </table>
</div>

<!-- Add Event Popup -->
<div class="popup" id="addPopup">
    <form action="#">
        <button class="closeBtn" id="closePopup">&times;</button>
        <h2>Add New Event</h2>
        <div>
            <label>Title</label>
            <input type="text" />
        </div>
        <div>
            <label>Location</label>
            <input type="text" />
        </div>
        <div>
            <label>Description</label>
            <textarea rows="5"  placeholder="Add description"></textarea>
        </div>
        <div>
            <label>Start date</label>
            <input type="date" />
            <label>End date</label>
            <input type="date" />
        </div>
        <div>
            <label>Ticket Price</label>
            <input type="number" />
        </div>
        <div>
            <label>Image</label>
            <input type="file" accept="image/*"/>
        </div>

        <div class="speakers-partners-agenda">
            <div class="spa-header">
                <h3>Speakers</h3>
                <button type="button" id="addSpeaker">+</button>
            </div>
            <div class="import-speaker"></div>

            <div class="spa-header">
                <h3>Partners</h3>
                <button type="button" id="addPartner">+</button>
            </div>
            <div class="import-partner"></div>
            <div class="spa-header">
                <h3>Contacts</h3>
                <button type="button" id="addContact">+</button>
            </div>
            <div class="import-contact"></div>

            <div class="spa-header">
                <h3>Agenda</h3>
                <button type="button" id="addDay">+</button>
            </div>
            <div class="import-day"></div>
        </div>

        <button type="button" id="addBtn">Add Event</button>
    </form>
</div>

<script src="/js/controlPanel.js"></script>

</body>
</html>