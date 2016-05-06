<!DOCTYPE html>

<html>
<head>
    <title>Edit listtbl data</title>
</head>

<?php
    session_start(); //starts the session
    if($_SESSION['user']){
    }
        else {
            header("location:index.php"); //redirects if user is not logged in.
        }
        $user = $_SESSION['user']; //assigns user value
        $id_exists = false; 
?>

<body>
<h2>Edit listtbl data</h2>

<p>Hello <?php Print "$user"?>!</p> <!--displays user's name -->
<a href="logout.php">Click here to logout.</a><br/><br/>
<a href="home.users.html.php">Return to user Home Page.</a>
<h2 align="center">Currently Selected Record</h2>
<table border="1px" width="100%">
    <tr>
        <th>ID</th>
        <th>Details</th>
        <th>Post Time</th>
        <th>Edit Time</th>
        <th>Public Post</th>
    </tr>
    
     <?php
        if(!empty($_GET['id']))
        {
            $id = $_GET['id'];
            $_SESSION['id'] = $id;
            $id_exists = true;
        
        @mysql_connect("localhost", "ben", "WEBd#7") or die(mysql_error());
//Connect to server - this statement uses deprecated methods, do not use them in production.
        @mysql_select_db("userauthdb") or die ("Cannot connect to database"); //connect to database - uses deprecated methods, do not use them in production.
    
    $query = @mysql_query("SELECT * FROM listtbl WHERE id='$id'"); //SQL query
    
    $count = mysql_num_rows($query);
    if($count > 0)
    {
        
    while($row = @mysql_fetch_array($query)) {
        Print "<tr>";
        Print '<td align = "center">'.$row['id']."</td>";
        Print '<td align = "center">'.$row['details']."</td>";
        Print '<td align = "center">'.$row['date_posted']. " - ". $row['time_posted'] ."</td>";
        Print '<td align = "center">'.$row['date_edited']. " - ". $row['time_edited'] ."</td>";
        Print '<td align = "center">'.$row['public']."</td>";
        Print "</tr>";
        }
        }
        
        else {
            $id_exists = false;
        }
        
        }
    ?>
</table>
<br/>
<?php
    if($id_exists) {
        Print '
        <form action="edit.html.php" method="POST">
        Enter new detail: <input type="text" name="details"/><br/>
        Public post? <input type="checkbox" name="public[]" value="yes"/><br/>
        <input type="submit" value="Update list"/>
        </form>
        ';
        }
        else {
            Print '<h2 align="center">There is no data to be edited.</h2>';
        }
?>
</body>
</html>

<?php

    if($_SERVER['REQUEST_METHOD'] == "POST") //Added and  "if" to keep the page secure.
    {
    @mysql_connect("localhost", "ben", "WEBd#7") or die(mysql_error());
//Connect to server - this statement uses deprecated methods, do not use them in production.
    @mysql_select_db("userauthdb") or die ("Cannot connect to database"); //connect to database - uses deprecated methods, do not use them in production.
    
        
    $details = @mysql_real_escape_string($_POST['details']); //details is what the user enters.
    $public = "no";
    $id = $_SESSION['id'];
    
    $time = strftime("%X"); //time
    $date = strftime("%B %d, %Y"); //date
    
    foreach($_POST['public'] as $list) //get the data from the checkbox
    {
        if($list !=null) { //checks if checkbox is checked
            $public = "yes"; //sets value
        }
    }
    
    @mysql_query("UPDATE listtbl SET details='$details', public='$public', date_edited='$date', time_edited='$time' WHERE id='$id'"); //SQL query
    header("location:home.users.html.php");
    
    }

?>


