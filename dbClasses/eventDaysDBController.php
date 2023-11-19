<?php
require_once "dbController.php";
class eventDaysDBController extends dbController
{
    function insertEventDay($day, $eventID) {
        $query = "INSERT INTO eventdays (day, eventID) VALUES (? , ?)";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $day
            ),
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        $this->updateDB($query, $params);
    }

    function updateEventDay($eventDayID, $day, $eventID) {
        $query = "UPDATE eventdays SET day = ?, eventID = ? WHERE eventDayID = ?";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $day
            ),
            array(
                "param_type" => "i",
                "param_value" => $eventID
            ),
            array(
                "param_type" => "i",
                "param_value" => $eventDayID
            )
        );
        $this->updateDB($query, $params);
    }

    function deleteEventDays($eventID) {
        $query = "DELETE FROM eventdays WHERE eventID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        $this->updateDB($query, $params);
    }

    function getEventDay($eventDayID) {
        $query = "SELECT * FROM eventdays WHERE eventDayID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventDayID
            )
        );
        return $this->getDBResult($query, $params);
    }

    function getEventDays($eventID) {
        $query = "SELECT * FROM eventdays JOIN events ON eventdays.eventID = events.eventID WHERE events.eventID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        return $this->getDBResult($query, $params);

    }
}