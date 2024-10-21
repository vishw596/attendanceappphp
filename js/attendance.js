// $.ajax({
//   url:"./handlers/attendanceHandler.php",
//   type:'POST',
//   dataType:"",
//   data:{},
//   beforeSend:function(){},
//   success:function(res){},
//   error:function(err){}
// })
function loadSessions() {
  console.log("function called");

  $.ajax({
    url: "./handlers/attendanceHandler.php",
    type: "POST",
    dataType: "json",
    data: { action: "getSessions" },
    beforeSend: function () {},
    success: function (res) {
      let x = getSessionHTML(res);
      $("#drpdwn").html(x);
    },
    error: function (err) {
      alert("something went wrong");
    },
  });
}
function getSessionHTML(res) {
  let x = ``;
  x = x + `<option value="" disabled selected>Select Session</option>`;
  for (let i = 0; i < res.length; i++) {
    let temp = res[i];
    x =
      x +
      `<option value=${temp["id"]}> ${temp["term"]} ${temp["year"]}</option>`;
  }
  return x;
}

function fetchFacultyCourse(facid, sessionid) {
  $.ajax({
    url: "./handlers/attendanceHandler.php",
    type: "POST",
    dataType: "json",
    data: { facid: facid, sessionid: sessionid, action: "getFacultyCourses" },
    beforeSend: function () {},
    success: function (res) {
      let x = getCourseCardHTML(res);
      $("#subcard").html(x);
    },
    error: function (err) {
      alert("something went wrong");
    },
  });
}

function getCourseCardHTML(list) {
  let x = ``;
  for (let i = 0; i < list.length; i++) {
    x =
      x +
      `<div class="subject card bg-success text-white " style="width: 12rem;" data-classobject='${JSON.stringify(
        list[i]
      )}'>
            <div class="card-body">
                <h6 class="card-title">${list[i]["code"]} ${
        list[i]["title"]
      }</h6>
            </div>
        </div>`;
  }
  return x;
}

function getclassDetailsAreaHTML(classobj) {
  let dobj=new Date();    
  let ondate=`2023-02-01`;
  let year=dobj.getFullYear();//xxxx format
  let month=dobj.getMonth()+1;//returns 0-11
  if(month<10)
  {
      month="0"+month;//its a string now
  }
  let day=dobj.getDate();//1-31
  if(day<10)
  {
      day="0"+day;//its a string now
  }
  ondate=year+"-"+month+"-"+day;
  let x = ` <div class="d-flex flex-column flex-md-row align-items-center mb-4 bg-secondary text-white p-3 rounded border">
            <div class="flex-fill me-md-3 ">
                <span class="fs-4">Course Code: ${classobj["code"]}</span>
            </div>
            <div class="flex-fill me-md-3">
                <span class="fs-4">${classobj["title"]}</span>
            </div>
            <div class="flex-fill d-flex gap-1">
                <span class="fs-5">Date:</span>
                <input type="date" class="form-control bg-white text-dark" aria-label="Date" id="ondate" max='${ondate}' value='${ondate}'>
            </div>
        </div>`;

  return x;
}

function fetchStudentList(sessionid, courseid,facid,ondate) {
  $.ajax({
    url: "./handlers/attendanceHandler.php",
    type: "POST",
    dataType: "json",
    data: {
      sessionid: sessionid,
      courseid: courseid,
      facid:facid,
      ondate:ondate,
      action: "getStudentList",
    },
    beforeSend: function () {},
    success: function (res) {
      // alert(JSON.stringify(res));
      let x = getStudentListHTML(res);
      $("#attendanceEntries").html(x);
    },
    error: function (xhr,status,err) {
      alert("Error: " + xhr.status + " - " + xhr.statusText + "\n" + xhr.responseText);
    },
  });
}
function getStudentListHTML(res) {
  let x = `<div  class=" mb-4"><h2 class="text-center mb-4">Student Attendance</h2>
        <div class="row entry-labels">
            <div class="col-md-3">S.No.</div>
            <div class="col-md-3">Roll No</div>
            <div class="col-md-4">Name of Student</div>
            <div class="col-md-2">Attendance</div>
        </div>`;

  for (let i = 0; i < res.length; i++) {
    let checkedState = res[i]['isPresent'] == 'yes'?`checked`:``;
    x =
      x +
      ` <div class="attendance-entry row">
                <div class="col-md-3 mb-3">
                    <p class="form-control-static fs-5">${i + 1}</p>
                </div>
                  <div class="col-md-3 mb-3 ml-5">
                      <p class="form-control-static fs-5">${
                        res[i]["roll_no"]
                      }</p>
                  </div>
                  <div class="col-md-4 mb-3">
                      <p class="form-control-static fs-5">${res[i]["name"]}</p>
                  </div>
                  <div class="col-md-2 d-flex align-items-center mb-3">
                      <input type="checkbox" class="form-check-input cbpresent" data-studentid='${
                        res[i]["id"]
                      }' ${checkedState}>
                  </div>
                  <hr>
              </div>`;
  }
  x = x + `<div class="text-center reportsection">
                <button class="btn btn-primary" id = "reportBtn">Report</button>
            </div>
            <div id = "reportDiv"></div>"`;
  return x;
}

function saveAttendance(studentid, sessionid, courseid, facid, ondate,status) {
  $.ajax({
    url: "./handlers/attendanceHandler.php",
    type: "POST",
    dataType: "",
    data: {studentid:studentid,sessionid:sessionid,courseid:courseid,facid:facid,ondate:ondate,status:status,action:"saveattendance"},
    beforeSend: function () {},
    success: function (res) {
      // alert(res);
    },
    error: function (err) {
      alert("Something went wrong")
    },
  });
}
function downloadCSV(sessionid,courseid,facid)
{
  $.ajax({
      url:"./handlers/attendanceHandler.php",
      type:'POST',
      dataType:"json",
      data:{sessionid:sessionid,courseid:courseid,facid:facid,action:"generateReport"},
      beforeSend:function(){},
      success:function(res){
        // alert(JSON.stringify(res));
        let x = `<object data = ${res['filename']} type = "text/html" target="_parent"></object>`
        $("#reportDiv").html(x);
      },
      error:function(xhr,status,err){
        alert("Error: " + xhr.status + " - " + xhr.statusText + "\n" + xhr.responseText);
      }
    })
}
//when doc is loaded then perform it
$(function () {

  $.ajax({
    url: "./handlers/attendanceHandler.php",
    type: "POST",
    dataType: "json",
    data: { action: "getFacName" },
    beforeSend: function () {},
    success: function (res) {
      $("#facname").html("Faculty Name: " + res['name']);
      $("#hiddenfacid").val(facid);
      // fetchFacultyCourse(facid, value);
    },
    error: function (xhr, status, error) {
      alert("Something went wrong");
    },
  });
  // logout
  $("#logoutBtn").click(function () {
    $.ajax({
      url: "./handlers/logoutHandler.php",
      type: "POST",
      success: function (res) {
        document.location.replace("index.php");
      },
      error: function (err) {
        alert("Something Went Wrong");
      },
    });
  });
  //session loading
  loadSessions();

  $("#drpdwn").change(function () {
    $("#classdetails-area").html(``);
    $("#attendanceEntries").html(``);
    let value = $("#drpdwn").val();
    $.ajax({
      url: "./handlers/attendanceHandler.php",
      type: "POST",
      dataType: "json",
      data: { action: "getId" },
      beforeSend: function () {},
      success: function (res) {
        let facid = res;
        $("#hiddenfacid").val(facid);
        fetchFacultyCourse(facid, value);
      },
      error: function (xhr, status, error) {
        alert("Something went wrong");
      },
    });
  });

  $(document).on("click", ".subject", function (e) {
    let classobj = $(this).data("classobject");
    let x = getclassDetailsAreaHTML(classobj);
    $("#classdetails-area").html(x);

    //fill the student list
    let sessionid = $("#drpdwn").val();
    let courseid = classobj["id"];
    let facid = $("#hiddenfacid").val();
    let ondate = $("#ondate").val();
    $("#hiddencourseid").val(courseid);
    fetchStudentList(sessionid, courseid,facid,ondate);
  });

  $(document).on("click", ".cbpresent", function () {
    let ispresent = this.checked ? "yes":"no";
    let studentid = $(this).data("studentid");
    let sessionid = $("#drpdwn").val();
    let courseid = $("#hiddencourseid").val();
    let facid = $("#hiddenfacid").val();
    let ondate = $("#ondate").val();
    // alert(ispresent);
    // alert(studentid +" "+sessionid+" "+courseid+" "+facid+" " );
    saveAttendance(studentid, sessionid, courseid, facid, ondate,ispresent);
  });
  //fetch student list for given date
  $(document).on("change","#ondate",function(){
    let sessionid = $("#drpdwn").val();
    let courseid = $("#hiddencourseid").val();
    let facid = $("#hiddenfacid").val();
    let ondate = $("#ondate").val();    
    fetchStudentList(sessionid, courseid,facid,ondate);
  })

  $(document).on("click","#reportBtn",function(){
    let sessionid = $("#drpdwn").val();
    let courseid = $("#hiddencourseid").val();
    let facid = $("#hiddenfacid").val();
    downloadCSV(sessionid,courseid,facid);
  })
});
