<?php
$servername = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'registration';

$conn = new mysqli($servername, $username, $password, $database);

if($conn->connect_error){
    echo json_encode(['ok' => false, 'error' => 'Database connection failed']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm-password'] ?? '';

if($name == '' || $email == '' || $password == '' || $confirm_password == ''){
     echo json_encode(['ok' => false, 'error' => 'Please fill all fields']);
    exit;
}

if($password !== $confirm_password){
     echo json_encode(['ok' => false, 'error' => 'Passwords do not match']);
    exit;
}

$hashed = md5($password);

$doesEmailExist = "SELECT * FROM `user` WHERE email = '$email'";
$result = $conn->query($doesEmailExist);
if($result->num_rows > 0){
     echo json_encode(['ok' => false, 'error' => 'Email Already Exists']);
    exit;
}

$sql = "INSERT INTO `user` (email, name, password) VALUES ('$email', '$name', '$hashed')";

if($conn->query($sql) === TRUE){
   echo json_encode(['ok' => true, 'name' => $name]);
}
else{
   echo json_encode(['ok' => false, 'error' => 'Registration failed']);
}

$conn->close();
?>