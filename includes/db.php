<?php
$conn = mysqli_connect("localhost", "root", "", "health_wellness");

if ($conn){
    echo "Connection Successful";
} {
    echo "Connection failed: " . mysqli_connect_error();
}
?>