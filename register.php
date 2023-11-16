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

    if (!isset($_POST["username"], $_POST["email"], $_POST["password"], $_POST["passconfirm"])) {
        exit("Datele de inregistrare nu au fost obtinute");
    }

    if(empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["passconfirm"])) {
        exit("Datele de inregistrare nu au fost completate");
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        exit("Emailul introdus nu este valid");
    }

    if (preg_match("/[A-Za-z0-9]+/", $_POST["username"]) == 0) {
        exit("Username-ul introdus nu este valid");
    }

    if (strlen($_POST["password"]) > 30 || strlen($_POST["password"]) < 6) {
        exit("Parola trebuie sa fie intre 6 si 30 de caractere");
    }

    if ($stmt = $dbConnection->prepare("SELECT userID, password FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $_POST["username"]);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Username-ul deja exista, alegeti altul";
        } else {
            if($stmt = $dbConnection->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)")) {
                $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $stmt->bind_param("sss", $_POST["username"], $password, $_POST["email"]);
                $stmt->execute();
                echo "Utilizatorul a fost inregistrat cu succes!";

                $newUserID = $stmt->insert_id;

                $_SESSION["loggedin"] = TRUE;
                $_SESSION["name"] = $_POST["username"];
                $_SESSION["id"] = $newUserID;
                header("Location: home.php");

            } else {
                echo "Nu se poate face prepare statement";
            }
        }
        $stmt->close();
    } else {
        echo "Nu se poate face prepare statement";
    }

    $dbConnection->close();

?>