<?php
    require_once "dbClasses/speakersDBController.php";

    session_start();

if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["rol"])) {
    header("Location: /ProiectPHP/login.html");
    exit;
}

if ($_SESSION["rol"] != "admin") {
    header("Location: /ProiectPHP/controlPanel.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Speakers</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/controlPanel.css">
</head>

<body>

<div class="table">
    <div class="table-header">
        <p>Speakers Details</p>
        <div>
            <button class="new-event" id="addSpeaker">+ New Speaker</button>
            <button class="new-event" id="backControlPanel">Back to Panel</button>
        </div>
    </div>
</div>

<div class="table-section">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Description</th>
            <th>Occupation</th>
            <th>Email</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $speakersController = new speakersDBController();
            $speakers = $speakersController->getAllSpeakers();

            if (!empty($speakers)) {
                foreach ($speakers as $speaker) {
                    echo "<tr>";
                    echo "<td>".$speaker["speakerID"]."</td>";
                    echo "<td>".$speaker["img"]."</td>";
                    echo "<td>".$speaker["firstName"]."</td>";
                    echo "<td>".$speaker["lastName"]."</td>";
                    echo "<td>".$speaker["description"]."</td>";
                    echo "<td>".$speaker["occupation"]."</td>";
                    echo "<td>".$speaker["email"]."</td>";
                    echo '<td>
                           <a href="CRUD/edit/editSpeaker.php?id=' . $speaker["speakerID"] . '"><button class="edit-button"><i class="edit-button fa-solid fa-pen-to-square"></i></button></a>
                           <a href="CRUD/delete/deleteSpeaker.php?id='. $speaker["speakerID"].'"><button class="delete-button"><i class="fa-solid fa-trash"></i></button></a>
                    </td>';
                    echo "</tr>";
                }
            }
        ?>

        </tbody>
    </table>
</div>

<div class="popup" id="addPopup">
    <form action="CRUD/insert/insertSpeaker.php" method="post">
        <button class="closeBtn" id="closePopup">&times;</button>
        <h2>Add New Speaker</h2>
        <div>
            <label>First Name</label>
            <input type="text" name="firstName" required/>
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" name="lastName" required/>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" required/>
        </div>
        <div>
            <label>Occupation</label>
            <input type="text" name="occupation" required/>
        </div>
        <div>
            <label>Description</label>
            <textarea rows="5"  placeholder="Add description" name="description" required></textarea>
        </div>
        <div>
            <label>Image</label>
            <input type="text" name="img" required/>
        </div>

        <button type="submit" id="addBtn">Add Speaker</button>
    </form>
</div>




<script src="js/speakers.js"></script>

</body>
</html>