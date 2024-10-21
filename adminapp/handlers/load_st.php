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
            $output = '<table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Roll No.</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
            ';
            $dbo = new Database();
            $query = $dbo->conn->prepare("select * from student_details");
            try{
                $query->execute();
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

            }
            catch(Exception $e)
            {}
            echo "<a href='./handlers/add_st.php'><button id = ''class = 'btn btn-success my-3'>Add Student</button></a>";
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
                                    <button id = '".$st['id']."' class = 'btn btn-success'>Edit</button>
                                    </div>
                                    <div class='col-md-6'>
                                    <button id = '".$st['id']."' class = 'btn btn-danger'>Delete</button>
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