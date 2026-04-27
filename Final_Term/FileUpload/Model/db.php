<?php
class db {
    function connection() {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "section_c";

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
        if ($connection->connect_error) {
            die("Please connect the database: " . $connection->connect_error);
        }
        return
    }

    function signup($connection, $tablename, $name, $email, $website, $comment, $gender) {
        $sql = "INSERT INTO $tablename (name, email, website, comment, gender)
        VALUES ('$name', '$email', '$website', '$comment', '$gender')";
        $results = $connection->query($sql);
        return $result;
    }
}
?>