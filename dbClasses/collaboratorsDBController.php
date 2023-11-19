<?php
require_once "dbController.php";
class collaboratorsDBController extends dbController
{
    function insertCollaborator($name, $phoneNumber, $email, $website, $type, $img) {
        $query = "INSERT INTO collaborators (name, phoneNumber, email, website, type, img) VALUES (?, ?, ?, ?, ?, ?)";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $name
            ),
            array(
                "param_type" => "s",
                "param_value" => $phoneNumber
            ),
            array(
                "param_type" => "s",
                "param_value" => $email
            ),
            array(
                "param_type" => "s",
                "param_value" => $website
            ),
            array(
                "param_type" => "s",
                "param_value" => $type
            ),
            array(
                "param_type" => "s",
                "param_value" => $img
            )
        );
        $this->updateDB($query, $params);
    }

    function updateCollaborator($collaboratorID, $name, $phoneNumber, $email, $website, $type, $img) {
        $query = "UPDATE collaborators SET name = ?, phoneNumber = ?, email = ?, website = ?, type = ?, img = ? WHERE collaboratorID = ?";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $name
            ),
            array(
                "param_type" => "s",
                "param_value" => $phoneNumber
            ),
            array(
                "param_type" => "s",
                "param_value" => $email
            ),
            array(
                "param_type" => "s",
                "param_value" => $website
            ),
            array(
                "param_type" => "s",
                "param_value" => $type
            ),
            array(
                "param_type" => "s",
                "param_value" => $img
            ),
            array(
                "param_type" => "i",
                "param_value" => $collaboratorID
            )
        );
        $this->updateDB($query, $params);

    }

    function getCollaborator($collaboratorID) {
        $query = "SELECT * FROM collaborators WHERE collaboratorID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $collaboratorID
            )
        );
        return $this->getDBResult($query, $params);
    }

    function getAllCollaborators() {
        $query = "SELECT * FROM collaborators";
        return $this->getDBResult($query);
    }

    function deleteCollaborator($collaboratorID) {
        $query = "DELETE FROM collaborators WHERE collaboratorID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $collaboratorID
            )
        );
        $this->updateDB($query, $params);
    }
     function getEventCollaborators($eventID) {
         $query = "SELECT * FROM collaborators INNER JOIN eventscollaborators ON collaborators.collaboratorID = eventscollaborators.collaboratorID INNER JOIN 
    events ON eventscollaborators.eventID = events.eventID WHERE events.eventID = ?";

         $params = array(
             array(
                 "param_type" => "i",
                 "param_value" => "$eventID"
             )
         );
         return $this->getDBResult($query, $params);
     }

    function insertEventCollaborator($eventID, $collaboratorID) {
        $query = "INSERT INTO eventscollaborators (eventID, collaboratorID) VALUES (?, ?)";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            ),
            array(
                "param_type" => "i",
                "param_value" => $collaboratorID
            )
        );
        $this->updateDB($query, $params);
    }

    function removeEventCollaborators($eventID) {
        $query = "DELETE FROM eventscollaborators WHERE eventID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        $this->updateDB($query, $params);
    }

}