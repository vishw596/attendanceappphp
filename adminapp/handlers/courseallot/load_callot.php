<?php
session_start();
if (isset($_SESSION['current_admin'])) {
} else {
    header("location:" . "/attendancesys/index.php");
    die();
}

?>
<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . "/attendancesys/database/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'getCourseAllotData') {
            $res = [];
            $output = "<table class='table table-hover table-bordered table-striped'>
                <thead>
                    <tr>
                        <th width='10%'>Id</th>
                        <th width='20%'>Faculty Name</th>
                        <th width='20%'>Course</th>
                        <th width='20%'>Session</th>
                        <th width='20%'>Action</th>
                    </tr>
                </thead>
            ";
            $dbo = new Database();
            $query = $dbo->conn->prepare("SELECT fd.name,cd.title,cd.code,sed.year,sed.term,crd.id
             FROM course_allotment as crd,faculty_details as fd,course_details as cd ,session_details as sed 
            where crd.faculty_id = fd.id and cd.id = crd.course_id and sed.id = crd.session_id order by crd.id;");
            try {
                $query->execute();
                $res = $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
            }
            echo "<a href='./handlers/courseallot/add_callot.php' target = '_blank'><button id = ''class = 'btn btn-success my-3'>Add Course Allotment</button></a>";
            if (count($res) < 1) {
                $output .= "<tr><td colspan = '5'>NO DATA</td></tr></table>";
            } else {
                foreach ($res as $st) {
                    $output .= "<tr> <td>" . $st['id'] . "</td>
                                <td>" . $st['name'] . "</td>
                                <td>" . $st['title'] . "</td>
                                <td>" . $st['year']." ".$st['term']. "</td>
                                <td>
                                <div class = 'col-sm-12'>
                                <div class = 'row'>
                                    <div class='col-md-6'>
                                    <a href='./handlers/courseallot/edit_callot.php?id=" . $st['id'] . "' target ='_blank'><button id = '" . $st['id'] . "' class = 'btn btn-success col-md-12'>Edit</button></a>
                                    </div>
                                    <div class='col-md-6'>
                                    <button id = '" . $st['id'] . "' class = 'delete btn btn-danger col-md-12'>Delete</button>
                                    </div>
                                </div>
                                </div>
                                </td>
                                </tr>
                                ";
                }
            }
            echo $output;
        }
    }
}
