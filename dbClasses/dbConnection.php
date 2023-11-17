<?php

class dbConnection
{
    private $DATABASE_HOST;
    private $DATABASE_USER;
    private $DATABASE_PASSWORD;
    private $DATABASE_NAME;
    function __construct($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME) {
        $this->DATABASE_HOST = $DATABASE_HOST;
        $this->DATABASE_USER = $DATABASE_USER;
        $this->DATABASE_PASSWORD = $DATABASE_PASSWORD;
        $this->DATABASE_NAME = $DATABASE_NAME;
    }

    public function connectToDb() {
        $connection = mysqli_connect($this->DATABASE_HOST, $this->DATABASE_USER, $this->DATABASE_PASSWORD, $this->DATABASE_NAME);

        if (mysqli_connect_errno()) {
            exit("Nu se poate conecta la MySQL: ". mysqli_connect_error());
        }

        return $connection;

    }

}