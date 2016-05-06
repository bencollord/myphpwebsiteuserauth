<?php
    session_start();
    if($_SESSION['user']) {}
    else {
        header("location:index.php");
    }
    if($_SERVER['REQUEST_METHOD'] == "POST") //Added and  "if" to keep the page secure.
    {
    $details = @mysql_real_escape_string($_POST['details']); //details is what the user enters.
    $time = strftime("%X"); //time
    $date = strftime("%B %d, %Y"); //date
    $decision = "no";
    
      @mysql_connect("localhost", "ben", "WEBd#7") or die(mysql_error());
//Connect to server - this statement uses deprecated methods, do not use them in production.
    @mysql_select_db("userauthdb") or die ("Cannot connect to database"); //connect to database - uses deprecated methods, do not use them in production.
    
    foreach($_POST['public'] as $each_check) //get the data from the checkbox
    {
        if($each_check !=null) { //checks if checkbox is checked
            $decision = "yes"; //sets value
        }
    }
    
    @mysql_query("INSERT INTO listtbl (details, date_posted, time_posted, public) VALUES ('$details', '$date', '$time', '$decision')"); //SQL query
    header("location:home.users.html.php");
    
    }
    else{
        header("location:home.users.html.php"); //redirects back to home.users.html.php
    }
?>