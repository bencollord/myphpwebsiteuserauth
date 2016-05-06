<!--Purpose: Home page for logged-in users. Users will be able to write, edit, delete, and view records to/from the database table listtbl. Users will be able to logout.
Associated Files: index.php, logout.php, add.php, edit.html.php, and a function called myFunction() used to delete records, then this will use delete.php -->
<!DOCTYPE html>

<html>
<head>
    <title>User Home Page</title>
</head>

<?php
    session_start(); //starts the session
    if($_SESSION['user']){
    }
        else {
            header("location:index.php"); //redirects if user is not logged in.
        }
        $user = $_SESSION['user']; //assigns user value
?>

<body>
<h2>User Home Page</h2>
<p>Hello <?php Print "$user"?>!</p> <!--displays user's name -->
<a href="logout.php">Click here to logout.</a><br/><br/>
<form action="add.php" method="POST">
    Add more to list: <input type="text" name="details"/><br/>
    Public post? <input type="checkbox" name="public[]" value="yes"/><br/>
    <input type="submit" value="Add to list"/>
</form>

<h2 align="center">My List</h2>
<table border="1px" width="100%">
    <tr>
        <th>ID</th>
        <th>Details</th>
        <th>Post Time</th>
        <th>Edit Time</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    
    <?php
        @mysql_connect("localhost", "ben", "WEBd#7") or die(mysql_error());
//Connect to server - this statement uses deprecated methods, do not use them in production.
    @mysql_select_db("userauthdb") or die ("Cannot connect to database"); //connect to database - uses deprecated methods, do not use them in production.
    
    $query = @mysql_query("SELECT * FROM listtbl"); //SQL query
    while($row = @mysql_fetch_array($query)) {
        Print "<tr>";
        Print '<td align = "center">'.$row['id']."</td>";
        Print '<td align = "center">'.$row['details']."</td>";
        Print '<td align = "center">'.$row['date_posted']. " - ". $row['time_posted'] ."</td>";
        Print '<td align = "center">'.$row['date_edited']. " - ". $row['time_edited'] ."</td>";
        Print '<td align = "center"><a href="edit.html.php?id=' . $row['id'] . '">edit</a></td>';
        Print '<td align = "center"><a href="#" onclick="myFunction('.$row['id'].')">delete</a></td>';
        Print '<td align = "center">'.$row['public']."</td>";  
    }
    ?>
    
</table>
    <script>
        function myFunction(id){
            var r=confirm("Are you sure you want to delete this record?");
            if (r==true) {
                window.location.assign("delete.php?id=" + id);
                //code
            }
        }
    </script>
</body>
</html>
