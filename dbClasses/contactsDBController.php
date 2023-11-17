<?php
require_once "dbController.php";
class contactsDBController extends dbController
{
    function insertContact($firstName, $lastName, $phoneNumber, $email, $eventID) {
        $query = "INSERT INTO contacts (firstName, lastName, phoneNumber, email, eventID) VALUES (?, ?, ?, ?, ?)";

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
                "param_value" => $phoneNumber
            ),
            array(
                "param_type" => "s",
                "param_value" => $email
            ),
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        $this->updateDB($query, $params);
    }

    function getContactForEvent($eventID) {
        $query = "SELECT * FROM contacts JOIN events ON contacts.eventID = events.eventID WHERE events.eventID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        return $this->getDBResult($query, $params);
    }

    function updateContact($contactID, $firstName, $lastName, $phoneNumber, $email, $eventID) {
        $query = "UPDATE contacts SET firstName = ?, lastName = ?, phoneNumber = ?, email = ?, eventID = ? WHERE contactID = ?";

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
                "param_value" => $phoneNumber
            ),
            array(
                "param_type" => "s",
                "param_value" => $email
            ),
            array(
                "param_type" => "i",
                "param_value" => $eventID
            ),
            array(
                "param_type" => "i",
                "param_value" => $contactID
            )
        );
        $this->updateDB($query, $params);
    }

    function deleteContact($contactID) {
        $query = "DELETE FROM contacts WHERE contactID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $contactID
            )
        );
        $this->updateDB($query, $params);
    }

}