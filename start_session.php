<?php
// Start session and include necessary files
include(__DIR__ . "/config/auth_session.php");
include(__DIR__ . "/config/database.php");

// Retrieve the user_id from the session
$username = $_SESSION["username"];
?>