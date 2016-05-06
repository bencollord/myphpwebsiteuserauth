<?php
    session_start();
    @$username = mysql_real_escape_string($_POST['username']);
    @$password = mysql_real_escape_string($_POST['password']);
    @mysql_connect("localhost", "ben", "WEBd#7") or die(mysql_error());
//Connect to server - this statement uses deprecated methods, do not use them in production.
    @mysql_select_db("userauthdb") or die ("Cannot connect to database"); //connect to database - uses deprecated methods, do not use them in production.
    $query = mysql_query("SELECT * FROM registeruserstbl WHERE username='$username'");
    //Query if there are matching rows equal to $username.
    $exists = mysql_num_rows($query); //check to see if the username exists
    $table_users = "";
    $table_password = "";
    if($exists > 0) //IF there are no returning rows or no existing usernames...
    {
        while($row = mysql_fetch_assoc($query)) //display all rows from query
        {
            $table_users = $row['username'];
            //the first username row is passed on to the 4table_users, and so on until the query is finished.
            $table_password = $row['password']; //the first password row is passed to the $table_password, and so on until the query is finished. 
        }
        if (($username == $table_users) && ($password == $table_password)) //checks if there are any matching fields.
        {
            if($password == $table_password) {
                $_SESSION['user'] = $username; //set the username in a session. This serves as a global variable.
                header ("location: home.users.html.php"); //redirects the user to the authenticated users home page. 
            }
        }
        else{
            Print '<script>alert("Incorrect Password!");</script>'; //Prompts user
            Print '<script>window.location.assign("login.form.html.php");</script>'; //redirect to login page
        }
    }
         else{
            Print '<script>alert("Incorrect Username!");</script>'; //Prompts user
            Print '<script>window.location.assign("login.form.html.php);</script>'; //redirect to login page
        }
        
?>