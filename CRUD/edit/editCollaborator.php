<?php
    require_once('../../dbClasses/collaboratorsDBController.php');
    session_start();

    if (!isset($_SESSION["loggedin"])) {
        header("Location: /ProiectPHP/login.html");
        exit;
    }

    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];
        $collaboratorController = new collaboratorsDBController();
        $collaborator = $collaboratorController->getCollaborator($id);
    } else {
        exit("Id invalid");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = htmlentities($_POST["name"], ENT_QUOTES);
        $type = htmlentities($_POST['collaboratorType'], ENT_QUOTES);
        $email = htmlentities($_POST['email'], ENT_QUOTES);
        $phoneNumber = htmlentities($_POST['phoneNumber'], ENT_QUOTES);
        $website = htmlentities($_POST['website'], ENT_QUOTES);
        $img = htmlentities($_POST['img'], ENT_QUOTES);

        if ($name == "" || $type == "" || $email == "" || $phoneNumber == "" ||
            $website == "" || $img == "") {
            echo "Campurile sunt goale";
        }
        else {
            $collaboratorController = new collaboratorsDBController();
            $collaboratorController->updateCollaborator($id, $name, $phoneNumber, $email, $website, $type, $img);
            header("Location: /ProiectPHP/collaborators.php");
        }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Collaborators</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/css/controlPanel.css">
</head>

<body>

<div class="table">
    <div class="table-header">
        <p>Edit collaborator</p>
        <div>
            <button class="new-event" id="backControlPanel">Back to Collaborators</button>
        </div>
    </div>
</div>

<div class="popup" id="editPopup">
    <form action="" method="post">
        <h2>Edit collaborator</h2>
        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $collaborator[0]["name"]?>" required/>
        </div>
        <div>
            <label>Collaborator Type</label>
            <input type="radio" name="collaboratorType" id="r-1" value="Partner" required/><label for="r-1">Partner</label>
            <input type="radio" name="collaboratorType" id="r-2" value="Sponsor" required/><label for="r-2">Sponsor</label>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $collaborator[0]["email"]?>" required/>
        </div>
        <div>
            <label>Phone</label>
            <input type="tel" name="phoneNumber" value="<?php echo $collaborator[0]["phoneNumber"]?>" required/>
        </div>
        <div>
            <label>Web Address</label>
            <input type="url" name="website" value="<?php echo $collaborator[0]["website"]?>" required/>
        </div>
        <div>
            <label>Logo</label>
            <input type="text" name="img" value="<?php echo $collaborator[0]["img"]?>" required/>
        </div>

        <button type="submit" id="addBtn">Edit collaborator</button>
    </form>
</div>


<script src="/js/editcollaborator.js"></script>

</body>
</html>
