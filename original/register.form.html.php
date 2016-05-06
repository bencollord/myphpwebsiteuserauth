<!-- Purpose: register a user with a username and password. This will be data written to the database table containing registered users.
Associated files: index.php, register.form.html.php
name="username" and "password" must match database fields-->

<!DOCTYPE html>

<html>
<head>
    <title>Registration Page</title>
</head>

<body>

    <h2>Registration Page</h2>
    <a href="index.php">Return to Home Page</a><br/><br/>
    <form action="register.form.html.php" method="post">
        Enter Username: <input type="text" name="username" required="required"/><br/>
        Enter Password: <input type="password" name="password"        required="required" /><br/>
        <input type="submit" value="Register"/>
    </form>
</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = @mysql_real_escape_string($_POST['username']);
    $password = @mysql_real_escape_string($_POST['password']);
    
    
    $bool = @true;
    
    @mysql_connect("localhost", "ben", "WEBd#7") or die(mysql_error());
//Connect to server - this statement uses deprecated methods, do not use them in production.
    @mysql_select_db("userauthdb") or die ("Cannot connect to database"); //connect to database - uses deprecated methods, do not use them in production.
    $query = mysql_query("SELECT * FROM registeruserstbl"); //this extension is deprecated.
    while($row = mysql_fetch_array($query)) //display all rows from the query.
    {
        $table_users = $row['username']; //the first username row is passed on to $table_users, and then so on until the query is finished.
        if($username == $table_users) {
            $bool = false; //set the bool to false
            Print '<script>alert("Username has been taken!");</script>'; //Prompt the user
            Print '<script>window.location.assign("register.form.html.php");</script>';
//redirect
        }
        
    }
    if($bool) //check if bool is true
    {
        mysql_query("INSERT INTO registeruserstbl (username, password) VALUES ('$username', '$password')"); //inserts the values into the table registerusertbl
        Print '<script>alert("Successfully Registered!");</script>'; //Prompts the user
        Print '<script>window.location.assign("register.form.html.php");</script>'; //redirects to register.form.html.php
    }
}
?>