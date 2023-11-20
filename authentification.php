<?php
    require_once "dbClasses/dbConnection.php";
    session_start();

    $dbConnection = new dbConnection("localhost", "root", "", "proiectphp");
    $connection = $dbConnection->connectToDb();

    if (mysqli_connect_errno()) {
        exit("Nu se poate conecta la MySQL: ". mysqli_connect_error());
    }

    if (!isset($_POST["username"], $_POST["password"])) {
        exit("Datele de logare nu au fost obtinute");
    }

    if ($stmt = $connection->prepare("SELECT userID, password, rol FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $_POST["username"]);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userID, $password, $rol);
            $stmt->fetch();

            if (password_verify($_POST["password"], $password)) {
                session_regenerate_id();
                $_SESSION["loggedin"] = TRUE;
                $_SESSION["name"] = $_POST["username"];
                $_SESSION["id"] = $userID;
                $_SESSION["rol"] = $rol;
                echo "Bine ati venit".$_SESSION["name"]."!";
                header("Location: controlPanel.php");
            } else {
                echo "Nume sau parola incorecte!";
            }
        } else {
            echo "Nume sau parola incorecte";
        }
        $stmt->close();
    }

