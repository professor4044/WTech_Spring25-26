<?php
$name = "";
$email = "";
$website = "";
$comment = "";
$gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $name = $_POST["name"];
    $email = $_POST["email"];
    $website = $_POST["website"];       
    $comment = $_POST["comment"];
    $gender = $_POST["gender"];

    $name = $_REQUEST["name"];
    $email = $_REQUEST["email"];
    $website = $_REQUEST["website"];
    $comment = $_REQUEST["comment"];
    $gender = $_REQUEST["gender"];
    $email = $_REQUEST["email"];

}
   
?>