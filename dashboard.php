<?php
    //include the php file to start session
    include("./start_session.php");

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
    <title>Dashboard -- PROTOTODOLIST</title>
    <link rel="shortcut icon" href="./img/logo3.png" type="image/x-icon">
    <!-- Bootstrap and CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- Navigational Bar -->
    <nav class="navbar navbar-dark">
        <div class="container-lg">
            <a href="./dashboard.php" style="text-decoration: none;">
                <span class="navbar-text">
                    Hey, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                
            </span>
            </button>

            <!-- Offcanvas -->

            <div class="sidebar offcanvas offcanvas-end" tabindex="-1"  id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a href="./dashboard.php" style="text-decoration: none;">
                    <span class="navbar-text">
                        Hey, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                    </span>
                </a>
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
                        <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Priorities
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./categories/high_priority.php">High</a></li>
                            <li><a class="dropdown-item" href="./categories/medium_priority.php">Medium</a></li>
                            <li><a class="dropdown-item" href="./categories/low_priority.php">Low</a></li>
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
        <h1>PROTOTODOLIST</h1>
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
                    <th>Task No.</th>
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
                                    class="btn-completed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16">
  <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
</svg></a>';
                                }
                            ?>
                            <a href="delete_task.php?task_id=<?php echo $fetch['task_id'] ?>"
                                    class="btn-remove"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
  <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
</svg>
                            </a>
                            <a href="undo_task.php?task_id=<?php echo $fetch['task_id'] ?>"
                                    class="btn-undo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-skip-backward-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.79-2.907L8.5 7.028V5.5a.5.5 0 0 0-.79-.407L5 7.028V5.5a.5.5 0 0 0-1 0v5a.5.5 0 0 0 1 0V8.972l2.71 1.935a.5.5 0 0 0 .79-.407V8.972l2.71 1.935A.5.5 0 0 0 12 10.5v-5a.5.5 0 0 0-.79-.407"/>
                                    </svg>
                            </a>

                            <?php
                                // Check the current priority and display only the relevant button
                                if ($fetch['priority'] == "high") {
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=high" class="btn-prio-high">🔴</a>';
                                } elseif ($fetch['priority'] == "medium") {
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=medium" class="btn-prio-medium">🟠</a>';
                                } elseif ($fetch['priority'] == "low") {
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=low" class="btn-prio-low">🟢</a>';
                                } else{
                                    // Show all priority options if no priority is set
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=high" class="btn-prio-high"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16">
  <circle cx="8" cy="8" r="8"/>
</svg></a>';
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=medium" class="btn-prio-medium"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16">
  <circle cx="8" cy="8" r="8"/>
</svg></a>';
                                    echo '<a href="priority_update.php?task_id=' . $fetch['task_id'] . '&priority=low" class="btn-prio-low"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16">
  <circle cx="8" cy="8" r="8"/>
</svg></a>';
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


