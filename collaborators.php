<?php
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

    <title>Collaborators</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/controlPanel.css">
</head>

<body>

<div class="table">
    <div class="table-header">
        <p>Collaborators Details</p>
        <div>
            <button class="new-event" id="addCollab">+ New Collaborator</button>
            <button class="new-event" id="backControlPanel">Back to Panel</button>
        </div>
    </div>
</div>

<div class="table-section">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Logo</th>
            <th>Name</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Website</th>
            <th>Type</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $collaboratorsController = new collaboratorsDBController();
            $collaborators = $collaboratorsController->getAllCollaborators();

            foreach ($collaborators as $collaborator) {
                echo "<tr>";
                echo "<td>".$collaborator["collaboratorID"]."</td>";
                echo "<td>".$collaborator["img"]."</td>";
                echo "<td>".$collaborator["name"]."</td>";
                echo "<td>".$collaborator["phoneNumber"]."</td>";
                echo "<td>".$collaborator["email"]."</td>";
                echo "<td>".$collaborator["website"]."</td>";
                echo "<td>".$collaborator["type"]."</td>";
                echo '<td>
                           <a href="CRUD/edit/editCollaborator.php?id=' . $collaborator["collaboratorID"] . '"><button class="edit-button"><i class="edit-button fa-solid fa-pen-to-square"></i></button></a>
                           <a href="CRUD/delete/deleteCollaborator.php?id='. $collaborator["collaboratorID"].'"><button class="delete-button"><i class="fa-solid fa-trash"></i></button></a>
                    </td>';
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</div>

<div class="popup" id="addPopup">
    <form action="CRUD/insert/insertCollaborator.php" method="post">
        <button class="closeBtn" id="closePopup">&times;</button>
        <h2>Add New Collaborator</h2>
        <div>
            <label>Name</label>
            <input type="text" name="name" value=""required/>
        </div>
        <div>
            <label>Collaborator Type</label>
            <input type="radio" name="collaboratorType" id="r-1" value="Partner" required/><label for="r-1">Partner</label>
            <input type="radio" name="collaboratorType" id="r-2" value="Sponsor" required/><label for="r-2">Sponsor</label>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" required/>
        </div>
        <div>
            <label>Phone</label>
            <input type="tel" name="phoneNumber" required/>
        </div>
        <div>
            <label>Web Address</label>
            <input type="url" name="website" required/>
        </div>
        <div>
            <label>Logo</label>
            <input type="text" name="img" required/>
        </div>

        <button type="submit" id="addBtn">Add Collaborator</button>
    </form>
</div>


<script src="/js/collaborators.js"></script>

</body>
</html>