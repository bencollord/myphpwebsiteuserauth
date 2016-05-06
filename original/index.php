<!-- Purpose: user interface, the first thing general public will see when coming to the website. It will have links to login and register users. It also will dispaly public information.
Associated files: login.form.html.php, register.form.html.php -->

<!DOCTYPE html>

<html>
<head>
    <title>Home Page</title>
</head>

<body>
    <h1>Home Page</h1>
    <a href="login.form.html.php">Click here to login</a><br/>
    <a href="register.form.html.php">Click here to register</a>
</body>
<br/>
<h2 align="center">List</h2>
<table width="100%" border="1px">
       <tr>
        <th>ID</th>
        <th>Details</th>
        <th>Post Time</th>
        <th>Edit Time</th>
    </tr>
       <?php
              @mysql_connect("localhost", "ben", "WEBd#7") or die(mysql_error());
//Connect to server - this statement uses deprecated methods, do not use them in production.
        @mysql_select_db("userauthdb") or die ("Cannot connect to database"); //connect to database - uses deprecated methods, do not use them in production.
    
    $query = @mysql_query("SELECT * FROM listtbl WHERE public='yes'"); //SQL query
    
    while($row = @mysql_fetch_array($query)) {
        Print "<tr>";
        Print '<td align = "center">'.$row['id']."</td>";
        Print '<td align = "center">'.$row['details']."</td>";
        Print '<td align = "center">'.$row['date_posted']. " - ". $row['time_posted'] ."</td>";
        Print '<td align = "center">'.$row['date_edited']. " - ". $row['time_edited'] ."</td>";
        Print "</tr>";
        }
        ?>
</table>
</html>
