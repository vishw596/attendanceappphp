<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . "/attendancesys/database/db.php";
class adminDetails
{
    public function verifyUser($dbo, $user, $pass)
    {
        $res = ["id" => -1, "status" => "Error"];
        $query = $dbo->conn->prepare("select id,password from admin_details where user_name=?");
        try {
            $query->execute([$user]);
            if ($query->rowCount() > 0) {
                $res = $query->fetchAll(PDO::FETCH_ASSOC)[0];
                if ($res['password'] == $pass) {
                    //all ok
                    $res = ["id" => $res['id'], "status" => "ALL OK"];
                } else {
                    //password does not match
                    $res = ["id" => -1, "status" => "invalid username or password"];
                }
            } else {
                $res = ["id" => -1, "status" => "invalid username or password"];
                //username does not exist
            }
        } catch (\Throwable $th) {
        }
        return $res;
    }
}