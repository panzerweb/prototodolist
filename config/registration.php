<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="shortcut icon" href="../img/logo3.png" type="image/x-icon">
    <!-- Bootstrap and CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="./css/reg.css">
    <link rel="stylesheet" href="./css/phpreg.css">
</head>
<body>
    <?php
    require("database.php");

    if (isset($_POST["submit"])) {
        // Check if any field is empty
        if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])) {
            echo 
            "   
                <div class='registration-form'>
                    <h3 class='error-message'>All fields are required!</h3>
                    <p class='link'>Click to <a href='registration.php'>try again</a></p>
                </div>
            ";
        } else {
            // Sanitize and escape input data
            $username = stripslashes($_POST["username"]);
            $username = mysqli_escape_string($connection, $username);
            $email = stripslashes($_POST["email"]);
            $email = mysqli_escape_string($connection, $email);
            $password = stripslashes($_POST["password"]);
            $password = mysqli_escape_string($connection, $password);
            $create_datetime = date('Y-m-d H:i:s');

            // Insert data into the database
            $query = "INSERT INTO `users_table` (username, password, email, create_datetime) 
                    VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime')";

            $result = mysqli_query($connection, $query);
            if ($result) {
                echo 
                "   <div class='registration-form'>
                        <h3 class='success-message'>Successful Registration!</h3>
                        <p class='link'>Click to <a href='login.php'>Login</a></p>
                    </div>
                ";
            } else {
                echo 
                "   <div class='registration-form'>
                        <h3 class='error-message'>Registration failed!</h3>
                        <p class='link'>Click to <a href='registration.php'>try again</a></p>
                    </div>
                ";
            }
        }
    } else {
    ?>

    <section class="registration-section">
        <div class="container-lg">
            <div class="form-wrapper">
                <form action="" method="post" class="registration">
                    <h3 class="form-title">Register Now!</h3>
                    
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control login-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control login-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control login-input" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" value="Register" name="submit" class="btn btn-primary login-button">
                    </div>
                    
                    <div class="form-footer">
                        <p class="link">Already have an account? <a href="login.php">Click to Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php
    }
    ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>