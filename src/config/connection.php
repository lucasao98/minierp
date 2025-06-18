<?php
    function connect_db() {
        //$host = "172.19.0.2";
        $host = "minierp_minierp-mysql";
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