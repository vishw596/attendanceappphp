<?php
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendancesys/database/db.php";
require_once $path."/attendancesys/database/adminDetails.php";
if ($method == 'POST') {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        echo "Invalid username or password";
    } else {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $dbo = new Database();
        $ado = new adminDetails();
        $res = $ado->verifyUser($dbo,$user,$pass);
        if($res['status'] == "ALL OK")
        {
            //if credentials are correct then start the session
            session_start();
            $_SESSION['current_admin'] = $res['id'];
        }

        //send response
        echo json_encode($res);

    }
}
