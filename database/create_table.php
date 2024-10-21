<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . '/attendancesys/database/db.php';
try {
    $db = new Database();
} catch (Throwable $th) {
    echo "Something Went wrong table<br>";
}
function clearTable($db,$tabName)
{
    $c="delete from :tabname";
    $s=$db->conn->prepare($c);
    try{
    $s->execute([":tabname"=>$tabName]);
    
    }
    catch(PDOException $oo)
    {
    }
}

//student details table
$st_details = $db->conn->prepare("create table student_details
(
    id int auto_increment primary key,
    roll_no varchar(20) unique,
    name varchar(50)
)");
try {
    $st_details->execute();
    echo "ST TABLE <br>";
} catch (Throwable $th) {
}

//course details table
$course_det = $db->conn->prepare("create table course_details
(
    id int auto_increment primary key,
    code varchar(20) unique,
    title varchar(50),
    credit int
)");
try {
    $course_det->execute();
    echo "course TABLE <br>";
} catch (Throwable $th) {
}

//faculty details

$faculty_det = $db->conn->prepare("create table faculty_details
(
    id int auto_increment primary key,
    user_name varchar(20) unique,
    name varchar(100),
    password varchar(64)
)");
try {
    $faculty_det->execute();
    echo "faculty TABLE <br>";
} catch (Throwable $th) {
}


//session details
$session_det = $db->conn->prepare("create table session_details
(
    id int auto_increment primary key,
    year int,
    term varchar(50),
    unique (year,term)
)");
try {
    $session_det->execute();
    echo "session TABLE <br>";
} catch (Throwable $th) {
}


//course_reg
$course_reg = $db->conn->prepare("create table course_registration
(
    student_id int,
    course_id int,
    session_id int,
    primary key (student_id,course_id,session_id),
    foreign key (student_id) references student_details(id) ON DELETE CASCADE 
    ON UPDATE CASCADE,
    foreign key (course_id) references  course_details(id) ON DELETE CASCADE 
    ON UPDATE CASCADE,
    foreign key (session_id) references session_details(id) ON DELETE CASCADE 
    ON UPDATE CASCADE
)");
try {
    $course_reg->execute();
    echo "course reg TABLE <br>";
} catch (Throwable $th) {
    
}


//course_allocation to faculty
$course_allot = $db->conn->prepare("create table course_allotment
(
    faculty_id int,
    course_id int,
    session_id int,
    primary key (faculty_id,course_id,session_id),
    foreign key (faculty_id) references faculty_details(id) ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key (course_id) references  course_details(id) ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key (session_id) references session_details(id) ON DELETE CASCADE ON UPDATE CASCADE
)");
try {
    $course_allot->execute();
    echo "course allotment TABLE <br>";
} catch (Throwable $th) {
}


//attendance detais
$attendance = $db->conn->prepare("create table attendance_details
(
    faculty_id int,
    course_id int,
    session_id int,
    student_id int,
    on_date date,
    status varchar(10),
    primary key (faculty_id,course_id,session_id,student_id,on_date),
    foreign key (student_id) references student_details(id) ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key (faculty_id) references faculty_details(id) ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key (course_id) references  course_details(id) ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key (session_id) references session_details(id) ON DELETE CASCADE ON UPDATE CASCADE

)");
try {
    $attendance->execute();
    echo "attendance TABLE <br>";
} catch (Throwable $th) {
}

$c="insert into student_details
(id,roll_no,name)
values
  (1,'CSB21001','BHASKAR JYOTI SUNGHA'),
  (2,'CSB21002','PALLABI BORA'),
  (3,'CSB21003','PRERONA SAIKIA'),
  (4,'CSB21004','SWAPNIL DEB'),
  (5,'CSB21005','AONEK AMARTYA KHYON HAZARIKA'),
  (6,'CSB21006','ANTARIP LAHKAR'),
  (7,'CSB21007','GURVINDRA SINGH'),
  (8,'CSB21008','DEBANGANA SAHA'),
  (9,'CSB21009','PRANAY BHARAT GAIKWAD'),
  (10,'CSB21010','ROMIT KUMAR'),
  (11,'CSB21011','TAMANNA NEGER'),
  (12,'CSB21012','ARNAB CHAKRABORTY'),

  (13,'CSM21001','UTTARA SAHA'),
  (14,'CSM21002','PROBAL DEEP SAIKIA'),
  (15,'CSM21003','SUBHROJIT SAIKIA'),
  (16,'CSM21004','GURLEEN KAUR'),
  (17,'CSM21005','RACHNA HARLALKA'),
  (18,'CSM21006','CHITRANKANA BHOWMIK'),
  (19,'CSM21007','HRITTIK BARUAH'),
  (20,'CSM21008','PRAGYANUR SAIKIA'),
  (21,'CSM21009','BIKRAM UPADHYAYA'),
  (22,'CSM21010','SHABBIR AHMAD'),
  (23,'CSM21011','ARNAB BISWAS'),
  (24,'CSM21012','NAROTTAM GOGOI')";

  $s=$db->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }


  $c="insert into faculty_details
(user_name,password,name)
values
('rcb','123','Ram Charan'),
('arindam','123','Arindam Karmakar'),
('pal','123','Pallabi'),
('anuj','123','Anuj Agarwal'),
('mriganka','123','Mriganka Sekhar'),
('manooj','123','Manooj Hazarika')";

  $s=$db->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }


  $c="insert into session_details
(year,term)
values
(2023,'Summer sem5'),
(2023,'Winter sem5')";

  $s=$db->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }


  $c="insert into course_details
(title,code,credit)
values
  ('Database management system lab','CO321',2),
  ('Pattern Recognition','CO215',3),
  ('Data Mining & Data Warehousing','CS112',4),
  ('ARTIFICIAL INTELLIGENCE','CS670',4),
  ('THEORY OF COMPUTATION ','CO432',3),
  ('DEMYSTIFYING NETWORKING ','CS673',1)";
  $s=$db->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }

  //if any record already there in the table delete them
  clearTable($db,"course_registration");
  $c="insert into course_registration
  (student_id,course_id,session_id)
  values
  (:sid,:cid,:sessid)";
  $s=$db->conn->prepare($c);
  //iterate over all the 24 students
  //for each of them chose max 3 random courses, from 1 to 6

  for($i=1;$i<=24;$i++)
  {
    for($j=0;$j<3;$j++)
    {
        $cid=random_int(1,6);
        //insert the selected course into course_registration table for 
        //session 1 and student_id $i
        try{
           $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>1]); 
        }
        catch(PDOException $pe)
        {

        }

        // repeat for session 2
        $cid=random_int(1,6);
        //insert the selected course into course_registration table for 
        //session 2 and student_id $i
        try{
           $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>2]); 
        }
        catch(PDOException $pe)
        {

        }
    }
  }


  //if any record already there in the table delete them
  clearTable($db,"course_allotment");
  $c="insert into course_allotment
  (faculty_id,course_id,session_id)
  values
  (:fid,:cid,:sessid)";
  $s=$db->conn->prepare($c);
  //iterate over all the 6 teachers
  //for each of them chose max 2 random courses, from 1 to 6

  for($i=1;$i<=6;$i++)
  {
    for($j=0;$j<2;$j++)
    {
        $cid=random_int(1,6);
        //insert the selected course into course_allotment table for 
        //session 1 and fac_id $i
        try{
           $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>1]); 
        }
        catch(PDOException $pe)
        {

        }

        //repeat for session 2
        $cid=random_int(1,6);
        //insert the selected course into course_allotment table for 
        //session 2 and student_id $i
        try{
           $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>2]); 
        }
        catch(PDOException $pe)
        {

        }
    }
  }