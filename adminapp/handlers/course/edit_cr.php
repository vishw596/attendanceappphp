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
$id = 0;
$title = '';
$code = '';
$credit = '';
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $id = $_GET['id'];
    $dbo = new Database();
    $query = $dbo->conn->prepare("SELECT * FROM course_details WHERE id = ?");
    try {
        $query->execute([$id]);
        $res = $query->fetchAll(PDO::FETCH_ASSOC)[0];
        $title = $res['title'];
        $code = $res['code'];
        $credit = $res['credit'];

    } catch (\Throwable $th) {
        
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title']) && isset($_POST['code']) && isset($_POST['credit'])) {
        $title = $_POST['title'];
        $code = $_POST['code'];
        $credit = $_POST['credit'];
        $id = (int)$_POST['id'];
        $dbo = new Database();
        $query = $dbo->conn->prepare("UPDATE course_details SET title = ?,code = ?,credit = ? WHERE id = ?");
        try {
            // echo var_dump($id);
            $query->execute([$title,$code,$credit,$id]);
            header('Location:../../adminCourse.php');
            exit();
        } catch (\Throwable $th) {
            //throw $th;
            echo "<script>alert('Failed')</script>";
        }
    }
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 jumbotron my-5">
                    <h4 class="text-center my-2">Edit Course Details</h4>
                    <form method="post" action="edit_cr.php">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" autocomplete="off" required value="<?php echo $title; ?>">
                        <label>Code</label>
                        <input type="text" name="code" class="form-control" autocomplete="off" required value="<?php echo $code; ?>">
                        <label>Credits</label>
                        <input type="number" name="credit" class="form-control" autocomplete="off" required value="<?php echo $credit; ?>">
                        <input type="submit" class="form-control btn btn-success" autocomplete="off" value="Update">

                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
    <!-- <script src="./js/jquery.js"></script>
    <script src="./js/admin.js"></script>  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>