<?php
require_once './config/database.php';
require_once './config/auth_session.php';

if (isset($_POST['add'])) {
    if ($_POST['task'] != "") {
        $task = $_POST['task'];
        $username = $_SESSION["username"];
 
        // Retrieve the user_id from the users_table based on the username
        $query = "SELECT user_id FROM users_table WHERE username = '$username'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['user_id'];

        $addtasks = mysqli_query($connection, 
            "INSERT INTO `task` (`task`, `status`, `user_id`) VALUES('$task', 'Pending', '$user_id')")
            or
            die(mysqli_error($connection));
            echo "Task inserted: $task, User ID: $user_id<br>";
        header("location: dashboard.php");
    }
    else{
        return header("location: dashboard.php");
    }
}
?>