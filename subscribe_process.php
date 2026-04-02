<?php
require_once("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Please enter a valid email address."]);
        exit();
    }

    $stmt = $con->prepare("INSERT INTO subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    try {
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Thank you for subscribing!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Something went wrong. Please try again."]);
        }
    } catch (Exception $e) {
        if ($con->errno === 1062) {
            echo json_encode(["status" => "success", "message" => "You are already a subscriber!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
        }
    }
}
?>
