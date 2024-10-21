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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Attendance Management System</title>
    <style>
        .bg-custom {
            background-color: #d1ecf1;
            /* Light blue background */
            color: #0c5460;
            /* Darker text color for better readability */
        }

        .entry-labels {
            font-weight: bold;
            /* Make labels bold */
            margin-bottom: 10px;
            /* Space between labels and entries */
        }
    </style>
</head>

<body>
    <nav class="navbar bg-body-tertiary col-sm-12 col-md-12 mb-4">
        <div class="container-fluid">
            <h1 class="navbar-brand fs-5">Attendance Management System</h1>
            <label id="facname">

            </label>
            <button class="btn btn btn-primary" type="button" id="logoutBtn">Logout</button>
        </div>
    </nav>






    <!-- SESSION DROPDOWN -->
    <div class="dropdown col-12 col-md-6 mx-auto d-flex justify-content-center mb-4">
        <select id="drpdwn" class="bg-whit text-black rounded border" style="height: 50px; width: 150px;">
        </select>
    </div>


    <!-- SUBJECT CARDS -->
    <div id="subcard" class="d-flex  d-sm-flex d-md-flex d-lg-flex flex-wrap justify-content-center justify-content-md-center justify-content-lg-center mb-3 gap-3">

    </div>





    <!-- COURSE DETAILS -->
    <div id = "classdetails-area" class="container my-4 mb-4">
       
    </div>

    <!-- STUDENT LIST -->
    <div class="container my-4 bg-custom" id="attendanceEntries">
        <!--
            -->
    </div>
    <input type=hidden id="hiddencourseid" value=-1>
    <input type=hidden id="hiddenfacid" value=-1>
    
        <script src="./js/jquery.js"></script>
        <script src="./js/attendance.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>