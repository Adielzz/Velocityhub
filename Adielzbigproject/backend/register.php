<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "velocityhub";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Memeriksa apakah kata sandi dan konfirmasi kata sandi cocok
    if ($password !== $confirmPassword) {
        echo "Kata sandi tidak cocok. Silakan coba lagi.";
        exit();
    }

    // Melindungi dari SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash kata sandi
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Menyimpan pengguna ke database
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil. Silakan <a href='../login_page.html'>login</a>.";

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
    $conn->close();
?>