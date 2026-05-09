<?php
include "../Model/db.php";

$name = "";
$password = "";
$email = "";
$website = "";
$comment = "";
$gender = "";
$file = "";

$nameErr = "";
$passwordErr = "";
$emailErr = "";
$genderErr = "";
$generalErr = "";
$fileErr = "";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
        $name = $_POST["name"] ?? "";
        $password = $_POST["password"] ?? "";
        $email = $_POST["email"] ?? "";
        $website = $_POST["website"] ?? "";
        $comment = $_POST["comment"] ?? "";
        $gender = $_POST["gender"] ?? "";
        $filepath = "";

        $name = $_REQUEST["name"] ?? "";
        $password = $_REQUEST["password"] ?? "";
        $email = $_REQUEST["email"] ?? "";
        $website = $_REQUEST["website"] ?? "";
        $comment = $_REQUEST["comment"] ?? "";
        $gender = isset($_REQUEST["gender"]) ? $_REQUEST["gender"] : "";
        $filepath = isset($_FILES["file"]) ? $_FILES["file"] : "";



        if(empty($name) || empty($email) || empty($gender) || empty($password))
        {
            $generalErr = "<p><span style='color: red; font-weight: bold;'>* Required fields</span></p>";
        }

        if(!empty($name))
            {
                echo "User Name: " . $name. "<br>";
            }
            else
            {
                $nameErr = "<span style='color: red;'>*</span>";
            }

        if(!empty($password))
            {
                if(strlen($password) >= 8)
                    {
                        echo " Password: " . str_repeat("*", strlen($password))."<br>";
                    }  
            }
            else
                {
                    $passwordErr = "<span style='color: red;'>*</span>";
                }

        if(!empty($email))
            {
                $emailPattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
                if(preg_match($emailPattern, $email))
                    {
                        echo " Email: " . $email."<br>";
                    }
                    else
                    {
                        $emailErr = "<span style='color: red;'>*</span>";
                        echo "Invalid Email Format. Email must be like example@email.com";
                    }
            }
            else
            {
                $emailErr = "<span style='color: red;'>*</span>";
            }

        if(!empty($website))
            {
                $urlPattern = "/^(https?:\/\/)?([\w\-]+\.)+[\w\-]+(\/[\w\-]*)*$/";
                if(preg_match($urlPattern, $website))
                    {
                        echo " Website: " . $website."<br>";
                    }
                    else
                    {
                        echo "Invalid URL Format. URL must be like http://example.com";
                    }
            }

            if(!empty($comment))
            {
                echo " Comment: " . $comment."<br>";
            }
            if(!empty($gender)) 
                {
                    echo " Gender: " . $gender."<br>";
                }
                else
                {
                    $genderErr = "<span style='color: red;'>*</span>";
                }
            
                if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0)
                {
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
                    $fileName = $_FILES["file"]["name"];
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    
                    if(in_array($fileExtension, $allowedExtensions))
                    {
                        $target_dir = "../File/";
                        $target_file = $target_dir . time() . "_" . basename($fileName);
                        
                        if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
                        {
                            //echo "File uploaded successfully: " . htmlspecialchars(basename($_FILES["file"]["name"]))."<br>";
                            $filepath = $target_file;
                        }
                        else
                        {
                            echo "Could not upload file. Please try again.";
                            $fileErr = "<span style='color: red;'>*</span>";
                        }
                    }
                    else
                    {
                        $fileErr = "<span style='color: red;'>*</span>";
                    }
                }
                else
                {
                    $fileErr = "<span style='color: red;'>*</span>";
                }

                if(empty($generalErr) && empty($nameErr) && empty($passwordErr) && empty($emailErr) && empty($genderErr) && empty($fileErr))
                {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $database = new db();
                    $connection = $database->connection();
                    $Result = $database->signup($connection, "users", $name, $hashedPassword, $filepath);

                    if($Result)
                    {
                        header("Location: ../View/login.php");
                        exit();
                    }
                    else
                    {
                        echo "Error: Could not save data to the database.";
                    }
                }
            





}
    
?>