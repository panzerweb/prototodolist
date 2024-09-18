<?php
include('./start_session.php');

// Sanitize and validate to prevent SQL Injections
$username = mysqli_real_escape_string($connection, $username);

$query = "SELECT * FROM users_table WHERE username = '$username'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

if(mysqli_num_rows($result) > 0){
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

if(isset($_POST['upload'])){
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./img/" . basename($filename); // Use basename for safety

    // Update the user's image path in the database
    $sql = "UPDATE users_table SET filename = '$filename' WHERE user_id = '$user_id'";
    mysqli_query($connection, $sql) or die(mysqli_error($connection));

    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>&nbsp; Image uploaded successfully!</h3>";
    } else {
        echo "<h3>&nbsp; Failed to upload image!</h3>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <!-- Bootstrap and CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/profile.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($username); ?></h1>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>
    <p>Password: <?php echo htmlspecialchars($password); ?></p>

    <div id="content">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input class="form-control" type="file" name="uploadfile" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
            </div>
        </form>
    </div>

    <div id="display-image">
        <h3>Profile Pic:</h3>
        <?php
        $query = "SELECT filename FROM users_table WHERE user_id = '$user_id'";
        $result = mysqli_query($connection, $query);

        if ($datafetch = mysqli_fetch_assoc($result)) {
            if (!empty($datafetch['filename'])) {
                echo '<img src="./img/' . htmlspecialchars($datafetch['filename']) . '" alt="User Image">';
            } else {
                echo '<p>No image uploaded.</p>';
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
