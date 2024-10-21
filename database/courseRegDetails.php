<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . "/attendancesys/database/db.php";
class CourseRegistrationDetails
{
    public function getRegisteredCourses($dbo,$sessionid,$courseid)
    {
        $res = [];
        $query = $dbo->conn->prepare("select sd.id,sd.name,sd.roll_no from student_details as sd,course_registration as
         cr where cr.student_id = sd.id and session_id = ? and course_id = ?");
        try {
            $query->execute([$sessionid,$courseid]);
            if($query->rowCount() > 0)
            {
                $res = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $res;
    }
}
?>