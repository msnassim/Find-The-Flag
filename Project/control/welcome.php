<?php 
session_start();
$user = $_SESSION['user'];
?>


<h1> Welcome <?php echo $user ?></h1>