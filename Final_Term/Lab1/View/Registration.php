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
    <form method = "post" action="">
        <table>
            <tr>
                <td><label for="name">Name:</label></td>
                <td>
                    <input type="text" id="name" name="name">
                    <?php echo $nameErr ?? ''; ?>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td>
                    <input type="text" id="email" name="email">
                    <?php echo $emailErr ?? ''; ?>
                </td>
            </tr>
                <tr>
                    <td><label for="website">Website:</label></td>
                    <td>
                        <input type="url" id="website" name="website">
                    </td> 
                </tr>
                <tr>
                    <td><label for="comment">Comment:</label></td>
                    <td><textarea id="comment" name="comment" rows="5" cols="40"></textarea></td>   
                </tr>
                <tr>
                    <td><label for="gender">Gender:</label></td>
                    <td>
                        <input type="radio" name="gender" value="female" <?php if (isset($_POST['gender']) && $_POST['gender'] == "female") echo "checked";?>> Female
                        <input type="radio" name="gender" value="male" <?php if (isset($_POST['gender']) && $_POST['gender'] == "male") echo "checked";?>> Male
                        <input type="radio" name="gender" value="other" <?php if (isset($_POST['gender']) && $_POST['gender'] == "other") echo "checked";?>> Other
                        <?php echo $genderErr ?? ''; ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" id="submitbutton" name="submit"></td>  
                </tr>
        </table>
    </form>
</body>
</html>