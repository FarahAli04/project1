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

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if($email == '' || $password == ''){
   echo json_encode(['ok' => false, 'error' => 'Please fill all fields']);
    exit;
}

$hashed = md5($password);

$sql = "SELECT name FROM `user` WHERE email = '$email' AND password = '$hashed'";
$result = $conn->query($sql);

if($result->num_rows === 1){
    $row = $result->fetch_row();
    echo json_encode(['ok' => true, 'name' => $row[0]]);
}
else{
   echo json_encode(['ok' => false, 'error' => 'Wrong email or password']);
    exit;
}

$conn->close();
?>