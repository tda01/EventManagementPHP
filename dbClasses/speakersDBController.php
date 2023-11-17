<?php
require_once "dbController.php";
class speakersDBController extends dbController
{
    function insertSpeaker($firstName, $lastName, $description, $occupation, $email, $img) {
        $query = "INSERT INTO speakers (firstName, lastName, description, occupation, email, img) VALUES (?, ?, ?, ?, ?, ?)";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $firstName
            ),
            array(
                "param_type" => "s",
                "param_value" => $lastName
            ),
            array(
                "param_type" => "s",
                "param_value" => $description
            ),
            array(
                "param_type" => "s",
                "param_value" => $occupation
            ),
            array(
                "param_type" => "s",
                "param_value" => $email
            ),
            array(
                "param_type" => "s",
                "param_value" => $img
            )
        );
        $this->updateDB($query, $params);
    }

    function updateSpeaker($speakerID, $firstName, $lastName, $description, $occupation, $email, $img) {

        $query = "UPDATE speakers SET firstName = ?, lastName = ?, description = ?, occupation = ?, email = ?, img = ? WHERE speakerID = ?";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $firstName
            ),
            array(
                "param_type" => "s",
                "param_value" => $lastName
            ),
            array(
                "param_type" => "s",
                "param_value" => $description
            ),
            array(
                "param_type" => "s",
                "param_value" => $occupation
            ),
            array(
                "param_type" => "s",
                "param_value" => $email
            ),
            array(
                "param_type" => "s",
                "param_value" => $img
            ),
            array(
                "param_type" => "i",
                "param_value" => $speakerID
            )
        );
        $this->updateDB($query, $params);
    }

    function deleteSpeaker($speakerID) {
        $query = "DELETE FROM speakers WHERE speakerID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $speakerID
            )
        );
        $this->updateDB($query, $params);
    }

    function getSpeaker($firstName, $lastName, $email)
    {
        $query = "SELECT * FROM speakers WHERE firstName = ? AND lastName = ? AND $email = ?";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $firstName
            ),
            array(
                "param_type" => "s",
                "param_value" => $lastName
            ),
            array(
                "param_type" => "s",
                "param_value" => $email
            )
        );
        return $this->getDBResult($query, $params);
    }

    function getEventSpeakers($eventID) {

        $query = "SELECT * FROM speakers INNER JOIN eventsspeakers ON speakers.speakerID = eventsspeakers.speakerID INNER JOIN 
    events ON eventsspeakers.eventID = events.eventID WHERE events.eventID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => "$eventID"
            )
        );
        return $this->getDBResult($query, $params);

    }

    function insertEventSpeaker($eventID, $speakerID) {
        $query = "INSERT INTO eventsspeakers (eventID, speakerID) VALUES (?, ?)";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            ),
            array(
                "param_type" => "i",
                "param_value" => $speakerID
            )
        );
        $this->updateDB($query, $params);
    }

    function deleteEventSpeaker($eventID, $speakerID) {
        $query = "DELETE FROM eventsspeakers WHERE eventID = ? AND speakerID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            ),
            array(
                "param_type" => "i",
                "param_value" => $speakerID
            )
        );
        $this->updateDB($query, $params);
    }
}