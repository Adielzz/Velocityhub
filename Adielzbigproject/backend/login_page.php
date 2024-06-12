<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "velocityhub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if there are previous failed attempts
if (isset($_SESSION['login_attempts']) && isset($_SESSION['last_attempt_time'])) {
    $login_attempts = $_SESSION['login_attempts'];
    $last_attempt_time = $_SESSION['last_attempt_time'];

    // Check if 1 minute has passed since last failed attempt
    $one_minute_ago = time() - 60;
    if ($login_attempts >= 3 && $last_attempt_time > $one_minute_ago) {
        echo "Terlalu Banyak Kesalahan Login. Silahkan Coba Lagi Setelah 1 Menit.";
        exit();
    } elseif ($last_attempt_time <= $one_minute_ago) {
        // Reset login attempts if 1 minute has passed
        unset($_SESSION['login_attempts']);
        unset($_SESSION['last_attempt_time']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Protect against SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct
            $_SESSION['email'] = $email;
            // Reset login attempts after successful login
            unset($_SESSION['login_attempts']);
            unset($_SESSION['last_attempt_time']);
            header("Location: ../index.html"); // Redirect to a dashboard or another page
            exit();
        } else {
            // Incorrect password
            if (isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts']++;
            } else {
                $_SESSION['login_attempts'] = 1;
            }
            // Store last failed attempt time
            $_SESSION['last_attempt_time'] = time();

            // Block access for 1 minute after 3 failed attempts
            if ($_SESSION['login_attempts'] >= 3) {
                echo "Terlalu Banyak Kesalahan Login. Silahkan Coba Lagi Setelah 1 Menit.";
                exit();
            } else {
                echo "Invalid email or password.";
            }
        }
    } else {
        // User does not exist
        echo "Invalid email or password.";
    }
}
$conn->close();
?>