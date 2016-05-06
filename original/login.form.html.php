<!-- Purpose: login a user with a username and password. Users will type in their username and password to access non-public and public information. Also, users will be able to write to the database table.
Associated files: index.php, checklogin.php -->

<!DOCTYPE html>

<html>
<head>
    <title>Login Page</title>
</head>

<body>

    <h2>Login Page</h2>
    <a href="index.php">Return to Home Page</a><br/><br/>
    <form action="checklogin.php" method="post">
        Enter Username: <input type="text" name="username"        required="required"/><br/>
        Enter Password: <input type="password" name="password"        required="required" /><br/>
        <input type="submit" value="Login"/>
    </form>
    
</body>
</html>
