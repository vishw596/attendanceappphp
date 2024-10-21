<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendancesys/database/db.php";

class sessionDetails
{
    public function getSessions($dbo)
    {
        $res = [];
        $query = $dbo->conn->prepare("select * from session_details");
        try {
            $query->execute();
            if($query->rowCount() > 0)
            {
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

            }
        } catch (Throwable $th) {
        
        }
        return $res;
    }
}

?>