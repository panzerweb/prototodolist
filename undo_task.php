<?php
    
    require_once "./config/database.php";

    if(isset($_GET['task_id'])){
        $task_id = $_GET["task_id"];

        $revert_task = mysqli_query($connection, "UPDATE `task` SET `status` = 'Pending' WHERE `task_id` = $task_id") or die(mysqli_error($connection));

        header("location: dashboard.php");
    }
    
?>