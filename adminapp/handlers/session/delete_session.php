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
    if(isset($_POST['id']))
    {
        $res = -1;
        $id = $_POST['id'];
        $dbo = new Database();
        $query = $dbo->conn->prepare("DELETE FROM session_details where id = ?");
        try {
            $query->execute([$id]);
            $res = 1;
        } catch (\Throwable $th) {
            //throw $th;
            $res = -1;
        }
        echo json_decode($res);
    }

}
?>