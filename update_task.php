<?php
    require_once "./config/database.php";

    if ($_GET["task_id"] != "") {
        $task_id = $_GET["task_id"];

        $updatingtask = mysqli_query($connection, "UPDATE `task` SET `status` = 'Done' WHERE `task_id` = $task_id")
        or die(mysqli_error($connection));

        header("location: dashboard.php");
    }
?>