<?php

    require_once "./config/database.php";

    if (isset($_GET['task_id']) && isset($_GET['priority'])) {
        $task_id = $_GET["task_id"];
        $priority = $_GET['priority'];

        //Sanitize the input to prevent SQL Injections
        $task_id = mysqli_real_escape_string($connection, $task_id);
        $priority = mysqli_real_escape_string($connection, $priority);

        $updatingpriority = mysqli_query($connection, "UPDATE `task` SET `priority` = '$priority' WHERE `task_id` = $task_id")
        or die(mysqli_error($connection));

        header("location: dashboard.php");
        exit();
    }

?>