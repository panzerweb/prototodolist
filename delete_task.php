<?php
    require_once "./config/database.php";

    if ($_GET['task_id']) {
        $task_id = $_GET['task_id'];

        $deleting_task = mysqli_query($connection, "DELETE FROM `task` WHERE `task_id` = $task_id")
        or die(mysqli_error($connection));
        header("location: dashboard.php");
    }
?>