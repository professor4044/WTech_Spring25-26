<?php
include "../Model/db.php";
$name = "";
$email = "";
$website = "";
$comment = "";
$gender = "";
$nameErr = "";
$emailErr = "";
$genderErr = "";    
$reqErr = "";
$datafile = "../data.json";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $name = $_POST["name"];
    $email = $_POST["email"];
    $website = $_POST["website"];       
    $comment = $_POST["comment"];
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";

    $name = $_REQUEST["name"];
    $email = $_REQUEST["email"];
    $website = $_REQUEST["website"];
    $comment = $_REQUEST["comment"];
    $gender = isset($_REQUEST["gender"]) ? $_REQUEST["gender"] : "";

    if (empty($name) || empty($email) || empty($gender)) 
    {
        $generalErr = "<p><span style='color: red; font-weight: bold;'>* Required fields</span></p>";
    }

    if(!empty($name))
        {
            echo "User Name: " . $name . "<br>";
        }
        else{
            $nameErr = "<span style= 'color: red;'>*</span>";
        }

    if(!empty($email))
        {
            $emailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
            if(preg_match($emailPattern, $email))
            {
                echo "Email: " . $email . "<br>";
            }
            else
            {
                echo "Invalid email format. Email should be in the format: example@email.com";
            }
        }
        else{
            $emailErr = "<span style= 'color: red;'>*</span>";
        }
    if(!empty($website))
        {
            $urlPattern = "/^(https?:\/\/)?([\w\-]+\.)+[\w\-]+(\/[\w\- .\/?%&=]*)?$/";
            if(preg_match($urlPattern, $website))
            {
                echo "Website: " . $website . "<br>";
            }
            else
            {
                echo "Invalid URL format. URL must be  http://example.com";
            }
        
        }
    if(!empty($comment))
        {
            echo "Comment: " . $comment . "<br>";
        }
    if(!empty($gender))
        {
            echo "Gender: " . $gender . "<br>";
        }  
    else{
        $genderErr = "<span style= 'color: red;'>*</span>";
    } 

    //JSON
    if(!empty($name) && !empty($email) && !empty($gender))
    {
        $formdata = array(
            "name" => $name,
            "email" => $email,
            "website" => $website,
            "comment" => $comment,
            "gender" =>$gender
        );
        
        if(file_exists($datafile)){
            $existdata = file_get_contents($datafile);
            $tempdata = json_decode($existdata, true);
        }
        else{
            $tempdata = array();
        }

        if (!is_array($tempdata)) {
                $tempdata = array();
            }
        $tempdata[] = $formdata;
        $jsondata = json_encode($tempdata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if (file_put_contents($datafile, $jsondata)) {
            echo "Data Saved to JSON";
        }
        else{
            echo "Please Try Again!";
        }

        $data = file_get_contents($datafile);
        $mydata = json_decode($data, true);
    }
}
   
?>