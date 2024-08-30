<?php

// Start session and include necessary files
include(__DIR__ . "/config/auth_session.php");
include(__DIR__ . "/config/database.php");

// Retrieve the user_id from the session
$username = $_SESSION["username"];

// Retrieve the user_id from the users_table based on the username
$query = "SELECT user_id FROM users_table WHERE username = '$username'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
$user = mysqli_fetch_assoc($result);
$user_id = $user['user_id'];

// Prepare the query to retrieve tasks for the current user
$stmt = $connection->prepare("SELECT * FROM task WHERE user_id = ? ORDER BY task_id ASC");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard -- ToDoList</title>
    
    <!-- Bootstrap and CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- <nav class="navbar navbar-light">
        <div class="container-lg">
            <span class="navbar-text">
                Hey, <?php echo htmlspecialchars($_SESSION['username']); ?>!
            </span>
            <a href="./config/logout.php" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                <path d="M7.5 1v7h1V1z"/>
                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"/>
                </svg>
            </a>
        </div>
    </nav> -->
    <nav class="navbar navbar-dark">
        <div class="container-lg">
            <span class="navbar-text">
                Hey, <?php echo htmlspecialchars($_SESSION['username']); ?>!
            </span>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                
            </span>
            </button>

            <!-- Offcanvas -->

            <div class="sidebar offcanvas offcanvas-end" tabindex="-1"  id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <span class="navbar-text">
                    Hey, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav align-items-center justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="profile_settings.php">
                            Profile Settings
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Priorities
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">High</a></li>
                            <li><a class="dropdown-item" href="#">Medium</a></li>
                            <li><a class="dropdown-item" href="#">Low</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout" href="./config/logout.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                <path d="M7.5 1v7h1V1z"/>
                                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            </div>
        </div>
    </nav>

    <!-- Container for Main Section -->
    <div class="container">

        <!-- ==================================================================================== -->
        <!-- REFERENCE: https://www.geeksforgeeks.org/how-to-make-a-todo-app-using-php-mysql/ -->
         <!-- ==================================================================================== -->
        <div class="input-area">
            <form method="post" action="add_task.php" >
                <input type="text" name="task" id="task" placeholder="Add your Task Here...">
                <button class="btn" name="add">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-patch-plus-fill" viewBox="0 0 16 16">
                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0"/>
                    </svg>
                </button>
            </form>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Task Id</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $count = 1;
                    while ($fetch = $result->fetch_assoc()) {
                ?>
                <tr class="border-bottom">
                    <td>
                        <?php echo $count++ ?>
                    </td>
                    <td>
                        <?php echo $fetch['task'] ?>
                    </td>
                    <td>
                        <?php echo $fetch['status'] ?>
                    </td>
                    <td colspan="2" class="action">
                            <?php
                                if ($fetch['status'] != "Done") {
                                    echo
                                    '<a href="update_task.php?task_id=' . $fetch['task_id'] . '" 
                                    class="btn-completed">✅</a>';
                                }
                            ?>
                            <a href="delete_task.php?task_id=<?php echo $fetch['task_id'] ?>"
                                    class="btn-remove">❌
                            </a>
                            <a href="undo_task.php?task_id=<?php echo $fetch['task_id'] ?>"
                                    class="btn-undo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z"/>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466"/>
                                    </svg>
                            </a>

                            <?php
                                // Check the current priority and display only the relevant button
                                if ($fetch['priority'] == "high") {
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=none" class="btn-prio-high">🔴</a>';
                                } elseif ($fetch['priority'] == "medium") {
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=none" class="btn-prio-medium">🟠</a>';
                                } elseif ($fetch['priority'] == "low") {
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=none" class="btn-prio-low">🟢</a>';
                                } else {
                                    // Show all priority options if no priority is set
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=high" class="btn-prio-high">🔴</a>';
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=medium" class="btn-prio-medium">🟠</a>';
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=low" class="btn-prio-low">🟢</a>';
                                }
                                
                            ?>

                    </td>

                </tr>
                <?php
                    }
                ?>
            
            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


