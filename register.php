<?php
    require_once "dbClasses/dbConnection.php";
    session_start();

    $dbConnection = new dbConnection("localhost", "root", "", "proiectphp");
    $connection = $dbConnection->connectToDb();

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

    if (strlen($_POST["username"]) > 50 || strlen($_POST["username"]) < 6) {
        exit("Usernameul trebuie sa aiba intre 6 si 50 de caractere");
    }

    if (strlen($_POST["email"]) > 100) {
        exit("Email-ul nu trebuia sa aiba mai mult de 100 de caractere");
    }

    if (strlen($_POST["password"]) > 30 || strlen($_POST["password"]) < 6) {
            exit("Parola trebuie sa fie intre 6 si 30 de caractere");
        }

    if ($stmt = $connection->prepare("SELECT userID, password FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $_POST["username"]);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Username-ul deja exista, alegeti altul";
        } else {
            if($stmt = $connection->prepare("INSERT INTO users (username, password, email, rol) VALUES (?, ?, ?, ?)")) {
                $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $rol = "user";
                $stmt->bind_param("ssss", $_POST["username"], $password, $_POST["email"], $rol);
                $stmt->execute();
                echo "Utilizatorul a fost inregistrat cu succes!";

                $newUserID = $stmt->insert_id;

                $_SESSION["loggedin"] = TRUE;
                $_SESSION["name"] = $_POST["username"];
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["id"] = $newUserID;
                $_SESSION["rol"] = $rol;

                header("Location: controlPanel.php");

            } else {
                echo "Nu se poate face prepare statement";
            }
        }
        $stmt->close();
    } else {
        echo "Nu se poate face prepare statement";
    }

    $connection->close();

