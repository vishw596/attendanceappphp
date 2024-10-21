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

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['action']))
    {
        if($_POST['action'] == 'getStudentData')
        {
            $res = [];
            $output = "<table class='table table-hover table-bordered table-striped'>
                <thead>
                    <tr>
                        <th width='10%'>Id</th>
                        <th width='10%'>Roll No.</th>
                        <th width='20%'>Name</th>
                        <th width='10%'>Action</th>
                    </tr>
                </thead>
            ";
            $dbo = new Database();
            $query = $dbo->conn->prepare("select * from student_details");
            try{
                $query->execute();
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

            }
            catch(Exception $e)
            {}
            echo "<a href='./handlers/student/add_st.php' target = '_blank'><button id = ''class = 'btn btn-success my-3'>Add Student</button></a>";
            if(count($res) < 1)
            {
                $output .= "<tr><td colspan = '3'>NO DATA</td></tr></table>";
            }
            else
            {
                foreach($res as $st)
                {
                    $output .= "<tr> <td>".$st['id']."</td>
                                <td>".$st['roll_no']."</td>
                                <td>".$st['name']."</td>
                                <td>
                                <div class = 'col-sm-12'>
                                <div class = 'row'>
                                    <div class='col-md-6'>
                                    <a href='./handlers/student/edit_st.php?id=".$st['id']."' target ='_blank'><button id = '".$st['id']."' class = 'btn btn-success col-md-12'>Edit</button></a>
                                    </div>
                                    <div class='col-md-6'>
                                    <button id = '".$st['id']."' class = 'delete btn btn-danger col-md-12'>Delete</button>
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
?>