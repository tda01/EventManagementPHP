<?php
require_once "dbController.php";
class ticketsDBController extends dbController
{
    function insertTicketType($description, $price, $eventID) {
        $query = "INSERT INTO tickets (description, price, eventID) VALUES (?, ?, ?)";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $description
            ),
            array(
                "param_type" => "d",
                "param_value" => $price
            ),
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        $this->updateDB($query, $params);
    }

    function getTicketType($description, $price, $eventID) {
        $query = "SELECT * FROM tickets WHERE description = ? AND price = ? and eventID = ?";
        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $description
            ),
            array(
                "param_type" => "d",
                "param_value" => $price
            ),
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        return $this->getDBResult($query, $params);

    }
    function getEventTicketTypes($eventID) {
        $query = "SELECT tickets.description as ticketDescription, price, ticketID FROM tickets JOIN events ON tickets.eventID = events.eventID WHERE events.eventID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        return $this->getDBResult($query, $params);
    }

    function updateTicketType($description, $price, $eventID) {
        $query = "UPDATE tickets SET description = ?, price = ? where $eventID = ?";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $description
            ),
            array(
                "param_type" => "d",
                "param_value" => $price
            ),
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        $this->updateDB($query, $params);
    }

    function deleteTicketType($ticketID) {
        $query = "DELETE FROM tickets WHERE ticketID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $ticketID
            )
        );
        $this->updateDB($query, $params);
    }

    function sellTicket($buyerfirstName, $buyerLastName, $buyerEmail, $ticketID) {
        $query = "INSERT INTO soldtickets (buyerFirstName, buyerLastName, buyerEmail, ticketID) VALUES (?, ?, ?, ?)";

        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $buyerfirstName
            ),
            array(
                "param_type" => "s",
                "param_value" => $buyerLastName
            ),
            array(
                "param_type" => "s",
                "param_value" => $buyerEmail
            ),
            array(
                "param_type" => "i",
                "param_value" => $ticketID
            )
        );
        $this->updateDB($query, $params);
    }

    function getEventSoldTickets($eventID) {
        $query = "SELECT * FROM soldtickets INNER JOIN tickets ON soldtickets.ticketID = tickets.ticketID INNER JOIN events ON tickets.eventID = events.eventID WHERE events.eventID = ?";

        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $eventID
            )
        );
        return $this->getDBResult($query, $params);
    }
}