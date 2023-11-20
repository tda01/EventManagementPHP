<?php
    require_once "dbClasses/eventDBController.php";
    require_once "dbClasses/speakersDBController.php";
    require_once "dbClasses/collaboratorsDBController.php";

    session_start();

    if (!isset($_SESSION["loggedin"])) {
        header("Location: login.html");
        exit;
    }

    $eventsController = new eventDBController();
    $speakersController = new speakersDBController();
    $collaboratorsController = new collaboratorsDBController();
    $allSpeakers = $speakersController->getAllSpeakers();
    $allCollaborators = $collaboratorsController->getAllCollaborators();
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
            <a href="speakers.php"><button class="new-event" id="addEvent">Speakers</button></a>
            <a href="collaborators.php"><button class="new-event" id="addEvent">Collaborators</button></a>
            <a href="activities.php"><button class="new-event" id="addEvent">Activities</button></a>
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

            $events = $eventsController->getAllEvents();

            if (!empty($events)) {
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
                           <a href="home.php?id=' . $event["eventID"] . '"><button class="view-button"><i class="fa-solid fa-eye"></i></button></a>
                           <a href="CRUD/edit/editEvent.php?id=' . $event["eventID"] . '"><button class="edit-button"><i class="edit-button fa-solid fa-pen-to-square"></i></button></a>
                           <a href="CRUD/delete/deleteEvent.php?id='. $event["eventID"].'"><button class="delete-button"><i class="fa-solid fa-trash"></i></button></a>
                           
                    </td>';
                    echo "</tr>";
                }
            }
        ?>

        </tbody>
    </table>
</div>

<!-- Add Event Popup -->
<div class="popup" id="addPopup">
    <form action="CRUD/insert/insertActivity.php" method="post">
        <button type="button" class="closeBtn" id="closePopup">&times;</button>
        <h2>Add New Event</h2>
        <div>
            <label>Title</label>
            <input type="text" name="title" required />
        </div>
        <div>
            <label>Location</label>
            <input type="text" name="location" required />
        </div>
        <div>
            <label>Description</label>
            <textarea rows="5"  name="description" placeholder="Add description"></textarea>
        </div>
        <div>
            <label>Start date</label>
            <input type="date" name="dateStart" required/>
            <label>End date</label>
            <input type="date" name="dateEnd"/>
        </div>
        <div>
            <label>Ticket Price</label>
            <input type="number" name="ticketPrice" required/>
        </div>
        <div>
            <label>Ticket description</label>
            <input type="text" name="ticketDescription" required/>
        </div>
        <div>
            <label>Image</label>
            <input type="text" name="img"" required/>
        </div>

        <div class="speakers-partners-agenda">
            <div class="spa-header">
                <h3>Speakers</h3>
            </div>
            <div class="import-speaker">
                <select name="speakers[]" multiple>
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

            <div class="spa-header">
                <h3>Partners</h3>
            </div>
            <div class="import-partner">
                <select name="collaborators[]" multiple>
                    <option value="" disabled>Select an option</option>
                    <?php
                    if(!empty($allCollaborators)){
                        foreach ($allCollaborators as $collab) {
                            echo '<option value="' . $collab["collaboratorID"] . '">' . $collab["name"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="spa-header">
                <h3>Contact</h3>
            </div>
            <div class="import-contact">
                <div>
                    <label>First Name</label>
                    <input type="text" name="contactFirstName" required />
                </div>
                <div>
                    <label>Last Name</label>
                    <input type="text" name="contactLastName" required />
                </div>
                <div>
                    <label>Phone number</label>
                    <input type="text" name="contactPhoneNumber" required />
                </div>
                <div>
                    <label>Email</label>
                    <input type="text" name="contactEmail" required />
                </div>
            </div>

<!--            <div class="spa-header">-->
<!--                <h3>Agenda</h3>-->
<!--                <button type="button" id="addDay">+</button>-->
<!--            </div>-->
<!--            <div class="import-day"></div>-->
        </div>

        <button type="submit" id="addBtn">Add Event</button>
    </form>
</div>

<script src="/js/controlPanel.js"></script>

</body>
</html>