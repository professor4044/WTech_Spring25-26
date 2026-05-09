<?php
include "../Model/db.php";
session_start(); 

$name = "";
$password = "";
$loginErr = "";
$generalErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST["name"] ?? "";
    $password = $_POST["password"] ?? "";

    if (!empty($name) && !empty($password)) {
        
        $database = new db();
        $connection = $database->connection();
        
        $userRecord = $database->signin($connection, "users", $name, $password);

        if ($userRecord) {
            $_SESSION["loggedIn"] = true;
            $_SESSION["name"] = $name;
            setcookie("name", $name, time() + 3600, "/");

            if (isset($userRecord["filepath"])) {
                $_SESSION["filepath"] = $userRecord["filepath"];
            }

            header("Location: ../View/Dashboard.php"); 
            exit();
            
        } else {
            $loginErr = "<p><span style='color: red;'>Invalid username or password.</span></p>";
        }
    } else {
        $generalErr = "<p><span style='color: red;'>Please fill in all fields.</span></p>";
    }
}
?>