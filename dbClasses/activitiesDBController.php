<?php
require_once "dbController.php";
class activitiesDBController extends dbController
{
    function insertActivity($name, $hour, $speakerID, $dayID) {
        $query = "INSERT INTO activities (name, hour, speakerID, dayID) VALUES (?, ?, ?, ?)";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $name
            ),
            array(
                "param_type" => "s",
                "param_value" => $hour
            ),
            array(
                "param_type" => "i",
                "param_value" => $speakerID
            ),
            array(
                "param_type" => "i",
                "param_value" => $dayID
            )
        );
        $this->updateDB($query, $params);
    }

    function updateActivity($activityID, $name, $hour, $speakerID, $dayID) {
        $query = "UPDATE activities SET name = ?, hour  = ?, speakerID = ?, dayID = ? WHERE activityID = ?";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $name
            ),
            array(
                "param_type" => "s",
                "param_value" => $hour
            ),
            array(
                "param_type" => "i",
                "param_value" => $speakerID
            ),
            array(
                "param_type" => "i",
                "param_value" => $dayID
            ),
            array(
                "param_type" => "i",
                "param_value" => $activityID
            )
        );
        $this->updateDB($query, $params);
    }

    function deleteActivity($activityID) {
        $query = "DELETE FROM activities WHERE activityID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $activityID
            )
        );
        $this->updateDB($query, $params);
    }

    function getEventActivities($eventID) {
        $query = "SELECT * FROM activities JOIN eventdays ON activities.dayID = eventdays.eventDayID JOIN events ON eventdays.eventID = events.eventID WHERE events.eventID =?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        return $this->getDBResult($query, $params);
    }

    function getActivity($activityID) {
        $query = "SELECT * FROM activities WHERE activityID =?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $activityID
            )
        );
        return $this->getDBResult($query, $params);
    }

    function getAllActivities() {
        $query = "SELECT * FROM activities";
        return $this->getDBResult($query);
    }

}