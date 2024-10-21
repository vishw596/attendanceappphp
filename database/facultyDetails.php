<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . "/attendancesys/database/db.php";
class facultyDetails
{
    public function verifyUser($dbo, $user, $pass)
    {
        $res = ["id" => -1, "status" => "Error"];
        $query = $dbo->conn->prepare("select id,password from faculty_details where user_name=?");
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

    public function getCoursesInSession($dbo, $sessionid, $facid)
    {
        $res = [];
        $query = $dbo->conn->prepare("select cd.id,cd.title,cd.code from course_allotment as ca,course_details as cd where ca.course_id = cd.id and faculty_id = ? and session_id = ?");
        try {
            $query->execute([$facid, $sessionid]);
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $th) {
        }
        return $res;
    }
    public function getFacultyName($dbo,$facid)
    {
        $query = $dbo->conn->prepare("select name from faculty_details where id = ?");
        try {
            $query->execute([$facid]);
            $res = $query->fetchAll(PDO::FETCH_ASSOC)[0];

        } catch (\Throwable $th) {
            //throw $th;
        }
        return $res;
    }
}
