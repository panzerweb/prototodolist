<?php
    //Include the php file to start session
    include("../start_session.php");

    // Retrieve the user_id from the users_table based on the username
    $query = "SELECT user_id FROM users_table WHERE username = '$username'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    $user = mysqli_fetch_assoc($result);
    $user_id = $user['user_id'];

    // Prepare the query to retrieve Low priority tasks for the current user
    $stmt = $connection->prepare("SELECT * FROM task WHERE user_id = ? AND priority = 'Low' ORDER BY task_id ASC");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result(); 
?>

<!-- Render it on an html element -->
<!-- Show the logged user in a navbar -->
<!-- Create a table where it fetches the data of the result of the query -->
<!-- The following data to be fetched are: -->
<!-- task No., task, priority -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High Priority -- PROTOTODOLIST</title>
    <link rel="shortcut icon" href="../img/logo3.png" type="image/x-icon">
    <!-- Bootstrap and CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Navigational Bar -->
     
    <nav class="navbar navbar-dark">
        <div class="container-lg">
            <a href="../dashboard.php" style="text-decoration: none;">
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
                <a href="../dashboard.php" style="text-decoration: none;">
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
                            <li><a class="dropdown-item" href="./high_priority.php">High</a></li>
                            <li><a class="dropdown-item" href="./medium_priority.php">Medium</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout" href="../config/logout.php">
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

    <!-- Container for High Priority Section-->
     <div class="container">
        <h1>Low Priorities</h1>
        
        <!-- Table for high priority task -->
         <table class="table">
            <thead>
                <tr>
                    <th>Task No.</th>
                    <th>Task</th>
                    <th>Priority</th>
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
                    <td colspan="1">
                        <?php echo $fetch['task'] ?>
                    </td>

                    <td colspan="2" class="action">
                            <?php
                               echo $fetch["priority"];
                                
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
