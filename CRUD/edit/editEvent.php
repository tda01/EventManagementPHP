<?php
    require_once "../../dbClasses/eventDBController.php";
    require_once "../../dbClasses/speakersDBController.php";
    require_once "../../dbClasses/collaboratorsDBController.php";
    require_once "../../dbClasses/ticketsDBController.php";
    require_once "../../dbClasses/contactsDBController.php";
    require_once "../../dbClasses/eventDaysDBController.php";

    session_start();

    if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["rol"])) {
        header("Location: /ProiectPHP/login.html");
        exit;
    }

    if ($_SESSION["rol"] != "admin") {
        header("Location: /ProiectPHP/login.html");
        exit;
    }


    $eventsController = new eventDBController();
    $speakersController = new speakersDBController();
    $collaboratorsController = new collaboratorsDBController();
    $ticketController = new ticketsDBController();
    $contactController = new contactsDBController();
    $allSpeakers = $speakersController->getAllSpeakers();
    $allCollaborators = $collaboratorsController->getAllCollaborators();


    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];
        $event = $eventsController->getEvent($id);
        $ticket = $ticketController->getEventTicketTypes($id);
        $contact = $contactController->getContactForEvent($id);

    } else {
        exit("Id invalid");
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
        $eventController->updateEvent($id, $title, $location, $description, $img);


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
        $daysController->deleteEventDays($id);

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
                $daysController->insertEventDay($day, $id);
            }
        } else {
            $date = $startDate;
            $daysController->insertEventDay($date, $id);
        }

        // Tickets

        $ticketPrice = htmlentities($_POST["ticketPrice"]);
        $ticketDescription = htmlentities($_POST["ticketDescription"]);

        if ($ticketPrice == "" || $ticketDescription == "") {
            exit("Campurile sunt goale");
        }
        $ticketController = new ticketsDBController();
        $ticketController->updateTicketType($ticketDescription, $ticketPrice, $id);


        // Contact

        $contactFirstName = htmlentities($_POST["contactFirstName"]);
        $contactLasttName = htmlentities($_POST["contactLastName"]);
        $contactPhoneNumber = htmlentities($_POST["contactPhoneNumber"]);
        $contactEmail = htmlentities($_POST["contactEmail"]);

        if ($contactFirstName == "" || $contactLasttName == "" || $contactPhoneNumber == "" || $contactEmail == "") {
            exit("Campurile sunt goale");
        }

        $contactController = new contactsDBController();
        $contactController->updateContact($contactFirstName, $contactLasttName, $contactPhoneNumber, $contactEmail, $id);

        // Speakers
        $speakerController = new speakersDBController();
        $speakerController->deleteEventSpeakers($id);

        if (!empty($_POST["speakers"])) {
            $speakers = $_POST["speakers"];

            foreach ($speakers as $speaker) {
                $speakerController->insertEventSpeaker($id, $speaker);
            }
        }

        // Collaborators
        $collaboratorController = new collaboratorsDBController();
        $collaboratorController->removeEventCollaborators($id);

        if (!empty($_POST["collaborators"])) {
            $collaborators = $_POST["collaborators"];
            foreach ($collaborators as $collaborator) {
                $collaboratorController->insertEventCollaborator($id, $collaborator);
            }
        }

        header("Location: /ProiectPHP/controlPanel.php");

    }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit event</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/css/controlPanel.css">
</head>

<body>

<!-- Page Header -->

<div class="table">
    <div class="table-header">
        <p>Edit event</p>
        <div>
            <button class="new-event" id="backControlPanel">Back to events</button>
        </div>
    </div>
</div>

<!-- Add Event Popup -->
<div class="popup" id="editPopup">
    <form action="" method="post">
        <h2>Edit event</h2>
        <div>
            <label>Title</label>
            <input type="text" name="title" value="<?php echo $event[0]["title"]?>" required />
        </div>
        <div>
            <label>Location</label>
            <input type="text" name="location" value="<?php echo $event[0]["location"]?>" required />
        </div>
        <div>
            <label>Description</label>
            <textarea rows="5"  name="description" placeholder="Add description"><?php echo $event[0]["description"]?></textarea>
        </div>
        <div>
            <label>Start date</label>
            <input type="date" name="dateStart"" required/>
            <label>End date</label>
            <input type="date" name="dateEnd"/>
        </div>
        <div>
            <label>Ticket Price</label>
            <input type="number" name="ticketPrice"/ value="<?php echo $ticket[0]["price"]?>" required>
        </div>
        <div>
            <label>Ticket description</label>
            <input type="text" name="ticketDescription"/ value="<?php echo $ticket[0]["ticketDescription"]?>" required>
        </div>
        <div>
            <label>Image</label>
            <input type="text" name="img" value="<?php echo $event[0]["img"]?>" required"/>
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
                    <input type="text" name="contactFirstName" value="<?php echo $contact[0]["firstName"]?>" required />
                </div>
                <div>
                    <label>Last Name</label>
                    <input type="text" name="contactLastName"  value="<?php echo $contact[0]["lastName"]?>" required />
                </div>
                <div>
                    <label>Phone number</label>
                    <input type="text" name="contactPhoneNumber"  value="<?php echo $contact[0]["phoneNumber"]?>" required />
                </div>
                <div>
                    <label>Email</label>
                    <input type="text" name="contactEmail"  value="<?php echo $contact[0]["email"]?>" required />
                </div>
            </div>

            <!--            <div class="spa-header">-->
            <!--                <h3>Agenda</h3>-->
            <!--                <button type="button" id="addDay">+</button>-->
            <!--            </div>-->
            <!--            <div class="import-day"></div>-->
        </div>

        <button type="submit" id="addBtn">Edit event</button>
    </form>
</div>

<script src="/js/editEvent.js"></script>

</body>
</html>