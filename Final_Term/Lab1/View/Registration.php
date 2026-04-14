<?php
include"../Controller/RegistrationController.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <h2>PHP Form Validation Example</h2>
    <form>
        <table>
            <tr>
                <td><label for="name">Name:</label></td>
                <td><input type="text" id="name" name="name"></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="text" id="email" name="email"></td>
            </tr>
                <tr>
                    <td><label for="website">Website:</label></td>
                    <td><input type="text" id="website" name="website"></td> 
                </tr>
                <tr>
                    <td><label for="comment">Comment:</label></td>
                    <td><textarea id="comment" name="comment" rows="5" cols="40"></textarea></td>   
                </tr>
                <tr>
                    <td><label for="gender">Gender:</label></td>
                    <td>
                        <input type="radio" id="female" name="gender" value="female">Female
                        <input type="radio" id="male" name="gender" value="male">Male
                        <input type="radio" id="other" name="gender" value="other">Other
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" id="submitbutton" name="submit"></td>  
                </tr>
        </table>
    </form>
</body>
</html>