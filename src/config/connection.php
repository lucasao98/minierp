<?php
    function connect_db() {
        $host = "localhost";
        $dbname = "montinkerp";
        $connection = "mysql:host=" . $host . ";dbname=" . $dbname ;
        $user_name = "root";
        $password = "root";

        try {
            $conn = new PDO($connection, $user_name, $password);
            return $conn;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
?>