<?php
    session_start(); //starts the session
    if($_SESSION['user']) {} //checks if user is logged in
    else {
        header("location:index.php"); //redirects if user is not logged in
    }
    if($_SERVER['REQUEST_METHOD'] == "GET") //Added and  "if" to keep the page secure.
    {
    
      @mysql_connect("localhost", "ben", "WEBd#7") or die(mysql_error());
//Connect to server - this statement uses deprecated methods, do not use them in production.
    @mysql_select_db("userauthdb") or die ("Cannot connect to database"); //connect to database - uses deprecated methods, do not use them in production.
    
    $id = $_GET['id'];
    
    @mysql_query("DELETE FROM listtbl WHERE id='$id'"); //SQL query
    header("location:home.users.html.php");
    }
?>