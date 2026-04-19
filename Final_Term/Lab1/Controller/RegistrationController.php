<?php
$name = "";
$email = "";
$website = "";
$comment = "";
$gender = "";
$nameErr = "";
$emailErr = "";
$genderErr = "";    
$reqErr = "";

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
                echo "Invalid URL format. URL musb be  http://example.com";
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
}
   
?>