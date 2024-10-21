<?php
$path = $_SERVER["DOCUMENT_ROOT"];
require_once $path . '/attendancesys/database/db.php';
require_once $path . '/attendancesys/database/sessionDetails.php';
require_once $path . '/attendancesys/database/facultyDetails.php';
require_once $path . '/attendancesys/database/courseRegDetails.php';
require_once $path . '/attendancesys/database/attendanceDetails.php';

function createCSVReport($list, $filename)
{
    $error = 0;
    $path = $_SERVER["DOCUMENT_ROOT"];
    $finalFileName = $path . $filename;
    try {
        $fp = fopen($finalFileName, "w");
        foreach ($list as $it) {
            fputcsv($fp,$it);
        }
    } catch (\Throwable $th) {
        $error = 1;
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'getSessions') {
            $res = ["2023 Summer", "2024 Winter"];
            $dbo = new Database();
            $sdo = new sessionDetails();
            $res = $sdo->getSessions($dbo);
            echo json_encode($res);
        }
        if ($_POST['action'] == 'getId') {
            session_start();
            if (isset($_SESSION['current_user'])) {
                $id = $_SESSION['current_user'];
                echo json_encode($id);
            }
        }
        if ($_POST['action'] == 'getFacName') {
            session_start();
            if (isset($_SESSION['current_user'])) {
                $facid = $_SESSION['current_user'];
                $dbo = new Database();
                $fdo = new facultyDetails();
                $facname = $fdo->getFacultyName($dbo,$facid);
                echo json_encode($facname);
            }
        }
        if ($_POST['action'] == 'getFacultyCourses') {
            //    $res = [];
            $facid = $_POST['facid'];
            $sessionid = $_POST['sessionid'];
            $dbo = new Database();
            $fdo = new facultyDetails();
            $res = $fdo->getCoursesInSession($dbo, $sessionid, $facid);
            echo json_encode($res);
        }
        if ($_POST['action'] == 'getStudentList') {
            $sessionid = $_POST['sessionid'];
            $courseid = $_POST['courseid'];
            $facid = $_POST['facid'];
            $ondate = $_POST['ondate'];
            $dbo = new Database();
            $courseReg = new CourseRegistrationDetails();
            $allStudents = $courseReg->getRegisteredCourses($dbo, $sessionid, $courseid);
            $ado = new AttendanceDetails();
            $presentStudents = $ado->getAttendanceList($dbo, $sessionid, $courseid, $facid, $ondate);
            for ($i = 0; $i < count($allStudents); $i++) {
                $allStudents[$i]['isPresent'] = "no";
                for ($j = 0; $j < count($presentStudents); $j++) {
                    if ($allStudents[$i]['id'] == $presentStudents[$j]['student_id']) {
                        $allStudents[$i]['isPresent'] = "yes";
                        break;
                    }
                }
            }
            echo json_encode($allStudents);
        }
        if ($_POST['action'] == 'saveattendance') {
            // studentid:studentid,sessionid:sessionid,courseid:courseid,facid:facid,ondate:ondate,action:"saveattendance"
            $studentid = $_POST['studentid'];
            $sessionid = $_POST['sessionid'];
            $courseid = $_POST['courseid'];
            $facid = $_POST['facid'];
            $ondate = $_POST['ondate'];
            $status = $_POST['status'];
            $dbo = new Database();
            $ado = new AttendanceDetails();
            $res = $ado->saveAttendance($studentid, $sessionid, $courseid, $facid, $ondate, $dbo, $status);
            echo json_encode($res);
        }
        if ($_POST['action'] == 'generateReport') {
            // studentid:studentid,sessionid:sessionid,courseid:courseid,facid:facid,ondate:ondate,action:"saveattendance"
            $facid = $_POST['facid'];
            $sessionid = $_POST['sessionid'];
            $courseid = $_POST['courseid'];
            $dbo = new Database();
            $ado = new AttendanceDetails();
            $list = $ado->getAttendanceReport($dbo,$sessionid,$courseid,$facid);
            // $list = [
            //     [1, "CSB123", 24.00],
            //     [2, "CSB553", 45.00],
            //     [3, "CSB345", 67.00]
            // ];
            $filename = '/attendancesys/report.csv';
            createCSVReport($list, $filename);
            $res = ["filename" => $filename];
            echo json_encode($res);
        }
    }
}
