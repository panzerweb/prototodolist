<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap and CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="./css/log.css">
    <link rel="stylesheet" href="./css/phplog.css">


</head>
<body>
    <?php
        require("database.php");
        session_start();

            if (isset($_POST["username"])) {
                $username = stripslashes($_REQUEST["username"]);
                $username = mysqli_escape_string($connection, $username);
                $password = stripslashes($_REQUEST["password"]);
                $password = mysqli_escape_string($connection, $password);

                $query = "SELECT * FROM `users_table` WHERE username = '$username' AND password='" . md5($password) . "'";
                $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                $rows = mysqli_num_rows($result);

                    if ($rows == 1) {
                        $_SESSION["username"] = $username; // Ensure you're setting the session variable
                        header('Location: ../dashboard.php');
                        exit(); // Always include exit after header to stop further script execution
                    } else {
                        echo 
                            "<div class='registration-form'>
                                <h3 class='error-message'>Incorrect Username or Password</h3>
                                <p class='link'>Click to <a href='login.php'>try again</a></p>
                            </div>";
                    }
                    
            } else {            
    ?>

    <section class="login-section">
        <div class="container-lg">
            <div class="form-wrapper">
                <form action="" method="post" class="login-form">
                    <h3 class="form-title">Login Now</h3>
                    
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control login-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control login-input" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" value="Login" name="submit" class="btn btn-primary login-button">
                    </div>
                    
                    <div class="form-footer">
                        <p class="link">Don't have an account? <a href="registration.php">Click to Register</a></p>
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