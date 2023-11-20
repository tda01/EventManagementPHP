<?php

require_once "dbController.php";
class usersDBController extends dbController
{
    function getUserMails() {
        $query = "SELECT email from users WHERE rol='user'";
        return $this->getDBResult($query);
    }
}