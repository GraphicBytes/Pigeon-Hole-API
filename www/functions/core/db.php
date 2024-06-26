<?php

class db
{
    private $dbconn;

    function __construct()
    {
        global $dbhost, $dbuser, $dbpw, $dbname;

        $this->dbconn = new mysqli($dbhost, $dbuser, $dbpw, $dbname);
        if ($this->dbconn->connect_error) {
            die("Connection failed: " . $this->dbconn->connect_error);
        }
        $this->dbconn->set_charset("utf8mb4");
        $this->dbconn->autocommit(true);
    }

    function sql($query, ...$params)
    {
        $stmt = $this->dbconn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $this->dbconn->error);
        }

        if (!empty($params)) {
            $types = array_shift($params); // First element is types
            if (!$stmt->bind_param($types, ...$params)) {
                die("Bind failed: " . $stmt->error);
            }
        }

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        if (strpos($query, 'SELECT') === 0) {
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            $stmt->close();
            return true;
        }
    }

    function clean($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
?>
