<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['mem_id']) ? (int)$_POST['mem_id'] : 0;
    
    $title       = mysqli_real_escape_string($con, preg_replace('/\s+/', ' ', trim($_POST['title'])));
    $description = mysqli_real_escape_string($con, trim($_POST['description']));
    $price       = (int)$_POST['price'];
    $duration    = mysqli_real_escape_string($con, $_POST['duration']);
    $features    = mysqli_real_escape_string($con, trim($_POST['features']));
    $status      = mysqli_real_escape_string($con, $_POST['status']);

    if($id > 0) {
        $q = "UPDATE memberships SET title='$title', description='$description', price=$price, duration='$duration', features='$features', status='$status' WHERE id=$id";
        $msg = "Membership tier updated successfully!";
    } else {
        $q = "INSERT INTO memberships (title, description, price, duration, features, status) VALUES ('$title', '$description', $price, '$duration', '$features', '$status')";
        $msg = "Membership tier created successfully!";
    }

    if(mysqli_query($con, $q)) {
        $_SESSION['mem_success'] = $msg;
    } else {
        $_SESSION['mem_success'] = "Database Error: " . mysqli_error($con);
    }
    
    header("Location: manage-memberships.php");
    exit();
} else {
    header("Location: manage-memberships.php");
    exit();
}
?>
