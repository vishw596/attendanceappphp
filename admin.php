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
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .admin-panel-btn {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-body-tertiary col-sm-12 col-md-12 mb-4">
        <div class="container-fluid">
            <h1 class="navbar-brand fs-5">Admin</h1>
            <button class="btn btn btn-primary" type="button" id="logoutBtn">Logout</button>
        </div>
    </nav>
    <div class="container my-5">
        <h2 class="text-center mb-4">Admin Panel</h2>

        <div class="row">

            <div class="col-12 col-md-6 col-lg-4">
                <a href="./adminapp/adminStudent.php" target="_blank"><button type="button" class="btn btn-primary w-100 admin-panel-btn">Student</button></a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a href="./adminapp/adminCourse.php" target="_blank"><button type="button" class="btn btn-success w-100 admin-panel-btn">Course</button></a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a href="./adminapp/adminSession.php" target="_blank"><button type="button" class="btn btn-info w-100 admin-panel-btn">Session</button></a>
            </div>


            <div class="col-12 col-md-6 col-lg-4">
                <a href="./adminapp/adminFaculty.php" target="_blank"><button type="button" class="btn btn-warning w-100 admin-panel-btn">Faculty</button></a>
            </div>


            <div class="col-12 col-md-6 col-lg-4">
                <a href="./adminapp/adminCourseReg.php" target="_blank"><button type="button" class="btn btn-danger w-100 admin-panel-btn">Course Registration</button></a>
            </div>


            <div class="col-12 col-md-6 col-lg-4">
                <a href="./adminapp/adminCourseAllot.php" target="_blank"><button type="button" class="btn btn-secondary w-100 admin-panel-btn">Course Allotment</button></a>
            </div>
        </div>
    </div>

    <script src="./js/jquery.js"></script>
    <script src="./js/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>