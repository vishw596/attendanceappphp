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
$year = '';
$term = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(!isset($_GET['id']))
    {
        header('Location:../../adminSession.php');
            exit();
    }
    $id = $_GET['id'];
    $dbo = new Database();
    $query = $dbo->conn->prepare("SELECT * FROM session_details WHERE id = ?");
    try {
        $query->execute([$id]);
        $res = $query->fetchAll(PDO::FETCH_ASSOC)[0];
        $year = $res['year'];
        $term = $res['term'];
    } catch (\Throwable $th) {
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['term']) && isset($_POST['year']) && $_POST['id'] != 0) {
        $year = $_POST['year'];
        $term = $_POST['term'];

        $id = (int)$_POST['id'];
        $dbo = new Database();
        $query = $dbo->conn->prepare("UPDATE session_details SET year = ?,term = ? WHERE id = ?");
        try {
            // echo var_dump($id);
            $query->execute([$year, $term, $id]);
            header('Location:../../adminSession.php');
            exit();
        } catch (\Throwable $th) {
            //throw $th;
            echo "<script>alert('Failed')</script>";
        }
    } else {
        header('Location:../../adminSession.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 jumbotron my-5">
                    <h4 class="text-center my-2">Edit Session Details</h4>
                    <form method="post" action="edit_session.php">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <label>Year</label>
                        <input type="text" name="year" class="form-control" autocomplete="off" required value="<?php echo $year; ?>">
                        <label>Term</label>
                        <input type="text" name="term" class="form-control" autocomplete="off" required value="<?php echo $term; ?>">
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