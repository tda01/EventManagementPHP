<?php
require_once "dbConnection.php";
class dbController
{
    protected $connection;

    function __construct() {
        $dbConnection = new dbConnection("localhost", "root", "", "proiectphp");
        $this->connection = $dbConnection->connectToDb();
    }

    function getDBResult($query, $params = array()) {
        $sql_statement = $this->connection->prepare($query);
        if (!empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
        $result = $sql_statement->get_result();

        if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }

        $sql_statement->close();

        if (!empty($resultset)) {
            return $resultset;
        }

    }

    function updateDB($query, $params = array()) {
        $sql_statement = $this->connection->prepare($query);
        if (!empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
        $sql_statement->close();
    }

    function bindParams($sql_statement, $params)
    {
        $param_type = "";
        foreach ($params as $query_param) {
            $param_type .= $query_param["param_type"];
        }

        $bind_params[] = & $param_type;
        foreach ($params as $k => $query_param) {
            $bind_params[] = & $params[$k]["param_value"];
        }

        call_user_func_array(array(
            $sql_statement,
            'bind_param'
        ), $bind_params);
    }


}