
<?php
//the code below will end a user's session and redirect to the index.php page.
session_start();
session_destroy();
header("location:index.php");
?>