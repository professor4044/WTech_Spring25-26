<?php
class db
{
    function connection()
    {
        $db_host = "localhost";
        $db_user= "root";
        $db_password="";
        $db_name="section_c"; 

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
        if($connection->connect_error) {
            die("Could not Connect Database".$connection->connect_error);
        }
        return $connection;
    }

    function signup($connection, $tablename, $name, $password, $filepath)
    {
        $sql = "INSERT INTO " .$tablename. "(name, password, filepath) VALUES (?,?,?)";
        $result = $connection->prepare($sql);
        
        if($result) {
            $result->bind_param("sss", $name, $password, $filepath);
            return $result->execute();
        }
        return false;
    }

    function signin($connection, $tablename, $name, $password)
    {
        $sql = "SELECT * FROM ".$tablename." WHERE name=?";
        $result = $connection->prepare($sql);
        
        if($result) {
            $result->bind_param("s", $name);
            $result->execute();
            $result = $result->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    return $user; 
                }
            }
        }
        return false; 
    }
}
?>