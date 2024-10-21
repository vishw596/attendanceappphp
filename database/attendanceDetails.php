<?php
$path = $_SERVER["DOCUMENT_ROOT"];
require_once $path . '/attendancesys/database/db.php';
class AttendanceDetails
{
    public function saveAttendance($studentid, $sessionid, $courseid, $facid, $ondate,$dbo,$status)
    {
        $res = [-1];
        $query = $dbo->conn->prepare("insert into attendance_details (student_id,session_id,course_id,faculty_id,on_date,status) values(?,?,?,?,?,?)");
        try
        {
            $query->execute([$studentid,$sessionid,$courseid,$facid,$ondate,$status]);
            $res = [1];
        }
        catch(Throwable $th)
        {
            // $res = $th->getMessage();
            $query = $dbo->conn->prepare("update attendance_details set status = ? where student_id = ? and session_id = ? and course_id = ? and faculty_id = ? and on_date=?");
            try
            {
                $query->execute([$status,$studentid,$sessionid,$courseid,$facid,$ondate]);
                $res = [1];
            }
            catch(Throwable $th)
            {

            }

        }
        return $res;
    }
    public function getAttendanceList($dbo,$sessionid,$courseid,$facid,$ondate)
    {
        $res = [];
        $query = $dbo->conn->prepare("select student_id from attendance_details 
        where session_id = ? and course_id = ? and faculty_id=? and on_date =? and status = 'yes'");
        try
        {
            $query->execute([$sessionid,$courseid,$facid,$ondate]);
            if($query->rowCount() > 0)
            {
                $res = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch(Throwable $th)
        {
            $res = $th->getMessage();
        }
        return $res;
    }


    public function getAttendanceReport($dbo,$sessionid,$courseid,$facid)
    {
        $report =[];
        $sessionname = '';
        $coursename = '';
        $facname = '';
        try {
            $query = $dbo->conn->prepare("select * from session_details where id = ?");
            $query->execute([$sessionid]);
            $sd = $query->fetchAll(PDO::FETCH_ASSOC)[0];
            $sessionname = $sd['term']." ".$sd['year'];
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $query = $dbo->conn->prepare("select * from faculty_details where id = ?");
            $query->execute([$facid]);
            $fd = $query->fetchAll(PDO::FETCH_ASSOC)[0];
            $facname = $fd['name'];
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $query = $dbo->conn->prepare("select * from course_details where id = ?");
            $query->execute([$courseid]);
            $cd = $query->fetchAll(PDO::FETCH_ASSOC)[0];
            $coursename = $cd['code']."-".$cd['title'];
        } catch (\Throwable $th) {
            //throw $th;
        }
        array_push($report,["Session:",$sessionname]);
        array_push($report,["Course:",$coursename]);
        array_push($report,["Faculty:",$facname]);
        
        $total = 0;
        $start = 0;
        $end = 0;
        //get the total no of lecture conducted by faculty
        $query = $dbo->conn->prepare('select distinct on_date from attendance_details 
        where session_id = ? and course_id = ? and faculty_id = ? order by on_date');
        try {
            $query->execute([$sessionid,$courseid,$facid]);
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total = count($res);
            if($total > 0)
            {
                $start = $res[0]['on_date'];
                $end = $res[$total-1]['on_date'];
            }
        } catch (Throwable $th) {
            //throw $th;
        }

        array_push($report,["total",$total]);
        array_push($report,["start",$start]);
        array_push($report,["end",$end]);

        //get the no of attended class by each student
        $res = [];
        $query = $dbo->conn->prepare("select rsd.id,rsd.roll_no,rsd.name,count(ad.on_date) as attended from 
        (
           select sd.id,sd.roll_no,sd.name,crd.session_id,
           crd.course_id from student_details as sd,course_registration as crd
           where sd.id=crd.student_id and crd.session_id=:session_id and 
           crd.course_id=:course_id
        ) as rsd left join attendance_details as ad 
        on rsd.id=ad.student_id AND
        rsd.session_id=ad.session_id and 
        rsd.course_id =ad.course_id
        and status='YES'
        and 
        ad.faculty_id=:faculty_id
        group by rsd.id;"
        );

        try
        {
            $query->execute([":session_id"=>$sessionid,":course_id"=>$courseid,":faculty_id"=>$facid]);
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
        }

        for($i=0;$i<count($res);$i++)
        {
         $res[$i]['percent']=0.00;
         if($total>0)
         {
            $res[$i]['percent']=round($res[$i]['attended']/$total*100.00,2);
         }
        }
        array_push($report,["slno","rollno","name","attended","percent"]);
        $report = array_merge($report,$res);

        return $report;
    }
}
?>