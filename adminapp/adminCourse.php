<?php
session_start();
if (isset($_SESSION['current_admin'])) {
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
    <title>Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link href="./css/admin.css" rel="stylesheet"> -->
</head>

<body>
<nav class="navbar bg-body-tertiary col-sm-12 col-md-12 mb-4">
        <div class="container-fluid">
            <h1 class="navbar-brand fs-3 mx-auto">Course Details</h1>
        </div>
    </nav>
    <div class="container">
        
        <div class="col-md-12">
            <div class="result my-5">

            </div>
        </div>
    </div>


    <script src="./js/jquery.js"></script>
    <script src="./js/course.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>