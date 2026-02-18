<?php

$email = $_POST['email'];

$password = $_POST['password'];

if(empty($email) || empty($password))
{
echo "All fields required";
exit;
}

// database check here

echo "Login success";

?>
