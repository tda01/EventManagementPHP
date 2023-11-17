<?php
require_once "dbController.php";
class eventDBController extends dbController
{
    function getAllEvents() {
        $query = "SELECT * FROM events";
        return $this->getDBResult($query);
    }

    function getEvent($eventID) {
        $query = "SELECT * FROM events WHERE eventID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        return $this->getDBResult($query, $params);
    }

    function insertEvent($title, $location, $description, $img) {
        $query = "INSERT INTO events (title, location, description, img) VALUES (?, ?, ?, ?)";
        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $title
            ),
            array(
                "param_type" => "s",
                "param_value" => $location
            ),
            array(
                "param_type" => "s",
                "param_value" => $description
            ),
            array(
                "param_type" => "s",
                "param_value" => $img
            )
        );
        $this->updateDB($query, $params);
    }

    function updateEvent($eventID, $title, $location, $description, $img) {
        $query = "UPDATE events SET title = ?, location = ?, description = ?, img = ? WHERE eventID = ?";
        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $title
            ),
            array(
                "param_type" => "s",
                "param_value" => $location
            ),
            array(
                "param_type" => "s",
                "param_value" => $description
            ),
            array(
                "param_type" => "s",
                "param_value" => $img
            ),
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        $this->updateDB($query, $params);
    }

    function deleteEvent($eventID) {
        $query = "DELETE FROM events WHERE eventID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        $this->updateDB($query, $params);
    }

}