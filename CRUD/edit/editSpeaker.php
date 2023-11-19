<?php
    require_once('../../dbClasses/speakersDBController.php');
    session_start();

    if (!isset($_SESSION["loggedin"])) {
        header("Location: /ProiectPHP/login.html");
        exit;
    }

    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = $_GET["id"];
        $speakersController = new speakersDBController();
        $speaker = $speakersController->getSpeaker($id);
    } else {
        exit("Id invalid");
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $firstName = htmlentities($_POST["firstName"], ENT_QUOTES);
        $lastName = htmlentities($_POST['lastName'], ENT_QUOTES);
        $email = htmlentities($_POST['email'], ENT_QUOTES);
        $occupation = htmlentities($_POST['occupation'], ENT_QUOTES);
        $description = htmlentities($_POST['description'], ENT_QUOTES);
        $img = htmlentities($_POST['img'], ENT_QUOTES);

        if ($firstName == "" || $lastName == "" || $email == "" || $occupation == "" ||
            $description == "" || $img == "") {
            exit("Campurile sunt goale");
        }
        else {
            $speakersController->updateSpeaker($id, $firstName, $lastName, $description, $occupation, $email, $img);
            header("Location: /ProiectPHP/speakers.php");
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Speakers</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/css/controlPanel.css">
</head>

<body>

<div class="table">
    <div class="table-header">
        <p>Edit speaker</p>
        <div>
            <button class="new-event" id="backControlPanel">Back to speakers</button>
        </div>
    </div>
</div>



<div class="popup" id="editPopup">
    <form action="" method="post">
        <h2>Edit speaker</h2>
        <div>
            <label>First Name</label>
            <input type="text" name="firstName" value="<?php echo $speaker[0]["firstName"]?>" required/>
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" name="lastName" value="<?php echo $speaker[0]["lastName"]?>" required/>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $speaker[0]["email"]?>" required/>
        </div>
        <div>
            <label>Occupation</label>
            <input type="text" name="occupation" value="<?php echo $speaker[0]["occupation"]?>" required/>
        </div>
        <div>
            <label>Description</label>
            <textarea rows="5"  placeholder="Add description" name="description" required><?php echo $speaker[0]["description"]?></textarea>
        </div>
        <div>
            <label>Image</label>
            <input type="text" name="img" value="<?php echo $speaker[0]["img"]?>" required/>
        </div>

        <button type="submit" id="addBtn" value="Edit speaker">Edit speaker</button>
    </form>
</div>




<script src="/js/editspeaker.js"></script>

</body>
</html>