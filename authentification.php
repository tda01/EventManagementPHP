<?php
    session_start();

    $DATABASE_HOST = "localhost";
    $DATABASE_USER = "root";
    $DATABASE_PASS = "";
    $DATABASE_NAME = "proiectphp";

    $dbConnection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    if (mysqli_connect_errno()) {
        exit("Nu se poate conecta la MySQL: ". mysqli_connect_error());
    }

    if (!isset($_POST["username"], $_POST["password"])) {
        exit("Datele de logare nu au fost obtinute");
    }

    if ($stmt = $dbConnection->prepare("SELECT userID, password FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $_POST["username"]);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userID, $password);
            $stmt->fetch();

            if (password_verify($_POST["password"], $password)) {
                session_regenerate_id();
                $_SESSION["loggedin"] = TRUE;
                $_SESSION["name"] = $_POST["username"];
                $_SESSION["id"] = $userID;
                echo "Bine ati venit".$_SESSION["name"]."!";
                header("Location: home.php");
            } else {
                echo "Nume sau parola incorecte!";
            }
        } else {
            echo "Nume sau parola incorecte";
        }
        $stmt->close();
    }

?>