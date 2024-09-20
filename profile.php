<?php
include('./start_session.php');

// Sanitize and validate to prevent SQL Injections
$username = mysqli_real_escape_string($connection, $username);

$query = "SELECT * FROM users_table WHERE username = '$username'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Retrieve all personal details
    $user_id = $user['user_id'];
    $username = $user['username'];
    $email = $user['email'];
    $password = $user['password'];
} else {
    echo "User not Found";
    exit;
}

// Uploading the image
$msg = "";

if (isset($_POST['upload'])) {
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./img/" . basename($filename); // Use basename for safety

    // Check if a file has been selected
    if (!empty($filename)) {
        // Try to move the uploaded file to the desired folder
        if (move_uploaded_file($tempname, $folder)) {
            // File uploaded successfully, now update the database
            $sql = "UPDATE users_table SET filename = '$filename' WHERE user_id = '$user_id'";
            if (mysqli_query($connection, $sql)) {
                $_SESSION['dialogMessage'] = "Image uploaded successfully!";
            } else {
                $_SESSION['dialogMessage'] = "Failed to update the image in the database!";
            }
        } else {
            $_SESSION['dialogMessage'] = "Failed to upload the image!";
        }
    } else {
        $_SESSION['dialogMessage'] = "No file selected!";
    }

    // Redirect to avoid form resubmission on page refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
    // Check if there's a dialog message in the session
    if (isset($_SESSION['dialogMessage'])) {
        $dialogMessage = $_SESSION['dialogMessage'];
        unset($_SESSION['dialogMessage']); // Clear the session message after use
    }


// Nav profile
    //Get the user image
    $userImage = "";
    $queryImage = "SELECT filename FROM users_table WHERE user_id = '$user_id'";
    $imageResult = mysqli_query($connection, $queryImage);
        if($datafetch = mysqli_fetch_assoc($imageResult)){
            if (!empty($datafetch['filename'])) {
                $userImage = './img/' . htmlspecialchars($datafetch['filename']); // User image path
            } else {
                $userImage = './img/default-profile.png'; // Default profile image
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Bootstrap and CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/profile.css">
</head>
<body>
    <!-- Dialog Box -->
    <dialog id="uploadDialog" class="styled-dialog">
        <div class="dialog-content">
            <p id="dialogMessage"><?php echo isset($dialogMessage) ? htmlspecialchars($dialogMessage) : ''; ?></p>
            <button id="closeDialog" class="btn btn-primary mt-3">Close</button>
        </div>
    </dialog>
    <!-- Navigational Bar -->
    <nav class="navbar navbar-dark">
        <div class="container-lg">
            <div class="d-flex align-items-center">
                <a href="./dashboard.php" class="mx-2">
                    <img src="<?php echo $userImage; ?>" alt="User Image" class="navbar-image" style="width: 50px; height: 50px; border-radius: 50%;border: 2px solid white;">
                </a>
                <a href="./dashboard.php" style="text-decoration: none;">
                    <span class="navbar-text">
                        Hey, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                    </span>
                </a>
            </div>

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
                        <a class="nav-link" aria-current="page" href="profile.php">
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

    <div class="container mt-5">
        <div class="row">
            <!-- Left Side: User Info and Upload -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profile Picture</h4>
                    </div>
                    <div class="card-body text-center">
                        <?php
                        $query = "SELECT filename FROM users_table WHERE user_id = '$user_id'";
                        $result = mysqli_query($connection, $query);

                        if ($datafetch = mysqli_fetch_assoc($result)) {
                            if (!empty($datafetch['filename'])) {
                                echo '<img src="./img/' . htmlspecialchars($datafetch['filename']) . '" alt="User Image" class="img-thumbnail" style="max-width: 150px;">';
                            } else {
                                echo '<p>No image uploaded.</p>';
                            }
                        }
                        ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="input-group mb-3">
                                <input class="form-control-file d-none" type="file" name="uploadfile" id="uploadfile">
                                <label class="btn btn-formal-file mx-auto" for="uploadfile">Choose File</label>
                                <button class="btn btn-formal-upload mx-auto" type="submit" name="upload">Upload</button>
                            </div>
                        </form>

                        <h2><?php echo htmlspecialchars($username); ?></h2>

                        <h4>Email:</h4>
                        <p><?php echo htmlspecialchars($email); ?></p>
                        <h4>Password:</h4>
                        <p><?php echo str_repeat('•', strlen($password)); ?></p>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <script>
        // Get the dialog and the message element
        const uploadDialog = document.getElementById('uploadDialog');
        const closeDialog = document.getElementById('closeDialog');
        const dialogMessage = "<?php echo $dialogMessage; ?>";

        if (dialogMessage !== "") {
            uploadDialog.showModal();
        }

        // Close the dialog when clicking the button
        closeDialog.addEventListener('click', () => {
            uploadDialog.close();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
