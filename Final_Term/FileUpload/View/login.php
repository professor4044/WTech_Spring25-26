<?php
include "../Controller/loginvalidation.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <form method="post" action="">
        <h1> User Login </h1>
        
        <?php echo $generalErr; ?>
        <?php echo $loginErr; ?>
        <table>
            <tr>
                <td><label for="name">Username: </label></td>
                <td>
                    <input type="text" id="name" name="name">
                    
                </td>
            </tr>
            <tr>
                <td><label for="password">Password: </label></td>
                <td>
                    <input type="password" id="password" name="password">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <input type="submit" name="submit" value="Login">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>