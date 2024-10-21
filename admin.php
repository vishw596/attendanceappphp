<?php
session_start();
if (isset($_SESSION['current_user'])) {
} else {
    header("location:" . "/attendancesys/index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button><a href="./adminapp/adminStudent.php">Student</button>
</body>
</html>