// student login
var k;
var k1;

function signIn() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var remember = document.getElementById("remember");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("username", username.value);
    formData.append("password", password.value);
    formData.append("remember", remember.checked);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "vcode") {

                var verificationModal = document.getElementById("verificationModal");
                k = new bootstrap.Modal(verificationModal);
                k.show();

            } else if (t == "payment") {

                alert.classList = "alert alert-warning input1 d-block";
                alert.innerHTML = "Your grade has increased. You want to pay Rs.1000 to access web site. you have 1 month trial period. ";

                setTimeout(function() {
                    username.value = "";
                    password.value = "";
                    window.location = "studentDashboard.php";
                }, 5000);

            } else if (t == "dopayment") {

                var paym = document.getElementById("paym");
                k1 = new bootstrap.Modal(paym);
                k1.show();


            } else if (t == "second login") {

                username.value = "";
                password.value = "";
                window.location = "studentDashboard.php";
            } else if (t == "Invalid details") {

                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

                username.value = "";
                password.value = "";
                remember.checked = "";

            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

            }
        }
    };

    r.open("POST", "studentLoginProcess.php", true);
    r.send(formData);

}

function studentPay() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var pay = document.getElementById("pay");

    var formData = new FormData();
    formData.append("pay", pay.value);
    formData.append("username", username.value);
    formData.append("password", password.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Success") {
                k1.hide();
                username.value = "";
                password.value = "";

                window.location = "studentDashboard.php";

            } else {
                var alert = document.getElementById("alert2");
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };
    r.open("POST", "studentPayProcess.php", true);
    r.send(formData);
}

function studentPay2(id) {
    var paym = document.getElementById("paym" + id);
    k1 = new bootstrap.Modal(paym);
    k1.show();

}

function studentPay1(id) {

    var Sid = id;
    var pay = document.getElementById("pay" + id);
    var alert = document.getElementById("alert2" + id);

    var formData = new FormData();
    formData.append("pay", pay.value);
    formData.append("Sid", Sid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Success") {
                k1.hide();
                window.location = "studentDashboard.php";

            } else if (t == "ok1") {

                alert.classList = "alert alert-success input1 d-block";
                alert.innerHTML = "No need to Pay";
            } else if (t == "ok2") {

                alert.classList = "alert alert-success input1 d-block";
                alert.innerHTML = "No need to Pay";
            } else {

                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };
    r.open("POST", "studentPayProcess1.php", true);
    r.send(formData);
}

//student Verify
function studentVerify() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var vcode = document.getElementById("vcode");

    var alert = document.getElementById("alert1");

    var formData = new FormData();
    formData.append("username", username.value);
    formData.append("password", password.value);
    formData.append("vcode", vcode.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                k.hide();
                username.value = "";
                password.value = "";
                vcode.value = "";

                window.location = "studentDashboard.php";

            } else {

                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

            }
        }
    };
    r.open("POST", "studentVerifyProcess.php", true);
    r.send(formData);

}

//clear alert
function clearalert() {
    document.getElementById("alert").classList = "d-none";
}

//clear alert in modal
function clearalert1() {
    document.getElementById("alert1").classList = "d-none";
}

//student Logout proccess
function logOut() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Success") {
                window.location = "index.php";
            }
        }
    };
    r.open("GET", "studentLogoutProcess.php", true);
    r.send();
}

//go to notes and assignments
function goTo_N_A(x) {

    var subjectid = x;
    var load = document.getElementById("load");

    var formData = new FormData();
    formData.append("sid", subjectid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            load.innerHTML = t;
        }
    };
    r.open("POST", "studentN&Aview.php", true);
    r.send(formData);
}

function reloadp() {

    location.reload();
}

// update student profile

//show password
function showPassword() {
    var icon = document.getElementById("show");
    var input = document.getElementById("password");

    if (icon.className == "bi bi-eye") {
        input.type = "text";
        icon.className = "bi bi-eye-slash";
    } else {
        input.type = "password";
        icon.className = "bi bi-eye";
    }

}

//student profile update
function studentUpdate() {

    var email = document.getElementById("email");
    var password = document.getElementById("password");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("email", email.value);
    formData.append("password", password.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "ok") {
                location.reload();
            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };

    r.open("POST", "studentUpdateProfileProcess.php", true);
    r.send(formData);
}

//student assignments Upload
var bm;

function Uploadbtn(aid) {
    var m = document.getElementById("uploadModal" + aid);
    bm = new bootstrap.Modal(m);
    bm.show();
}

//student assignments sumbit
function studentUploadSubmit(id) {

    var as = id;
    var upload = document.getElementById("uploadFiles" + as);
    var alert = document.getElementById("alert" + as);

    var formData = new FormData();
    formData.append("uploadFile", upload.files[0]);
    formData.append("asID", as);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Assignment submitted successfully") {
                alert.classList = "alert alert-success input1 d-block";
                alert.innerHTML = t;
                setTimeout(function() {
                    bm.hide();
                    reloadp();
                }, 2000);

            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }

        }
    };

    r.open("POST", "studentUploadProcess.php", true);
    r.send(formData);
}

//clear alert in modal
function clearalertSU(id) {
    document.getElementById("alert" + id).classList = "d-none";
}

//teacher login
function signInT() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var remember = document.getElementById("remember");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("username", username.value);
    formData.append("password", password.value);
    formData.append("remember", remember.checked);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "vcode") {

                var verificationModal = document.getElementById("verificationModal");
                k = new bootstrap.Modal(verificationModal);
                k.show();

            } else if (t == "second login") {

                username.value = "";
                password.value = "";
                window.location = "teacherDashboard.php";
            } else if (t == "Invalid details") {

                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

                username.value = "";
                password.value = "";
                remember.checked = "";
            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

            }
        }
    };

    r.open("POST", "teacherLoginProcess.php", true);
    r.send(formData);

}

//teacher Verify
function teacherVerify() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var vcode = document.getElementById("vcode");

    var alert = document.getElementById("alert1");

    var formData = new FormData();
    formData.append("username", username.value);
    formData.append("password", password.value);
    formData.append("vcode", vcode.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                k.hide();
                username.value = "";
                password.value = "";
                vcode.value = "";

                window.location = "teacherDashboard.php";

            } else {

                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

            }
        }
    };
    r.open("POST", "teacherVerifyProcess.php", true);
    r.send(formData);

}

//teacher Logout proccess
function logOutT() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Success") {
                window.location = "teacherLogin.php";
            }
        }
    };
    r.open("GET", "teacherLogoutProcess.php", true);
    r.send();
}

// teacher profile Update
function teacherUpdate() {

    var email = document.getElementById("email");
    var password = document.getElementById("password");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("email", email.value);
    formData.append("password", password.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "ok") {
                location.reload();
            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };

    r.open("POST", "teacherUpdateProfileProcess.php", true);
    r.send(formData);
}

// teachser add notes and assignments
function goTo_Add_N_A(x) {

    var gsid = x;
    var load = document.getElementById("load");

    var formData = new FormData();
    formData.append("gsid", gsid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            load.innerHTML = t;
        }
    };
    r.open("POST", "teacherAddN&A.php", true);
    r.send(formData);
}

//teacher add notes modal
function addNotes(i) {

    var m = document.getElementById("addNoteModal" + i);
    bm = new bootstrap.Modal(m);
    bm.show();

}

//teacher add notes
function addLessonNote(id) {

    var gsid = id;
    var Lname = document.getElementById("Lname");
    var Add = document.getElementById("addLNote");
    var alertT = document.getElementById("alert");

    var formData = new FormData();
    formData.append("Lname", Lname.value);
    formData.append("addLNote", Add.files[0]);
    formData.append("gsID", gsid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Lesson added successfully") {
                alertT.classList = "alert alert-success input1 d-block";
                alertT.innerHTML = t;
                setTimeout(function() {
                    bm.hide();
                    reloadp();
                }, 2000);

            } else {
                alertT.classList = "alert alert-danger input1 d-block";
                alertT.innerHTML = t;
            }

        }
    };

    r.open("POST", "teacherAddNoteProcess.php", true);
    r.send(formData);
}

//teacher add assignments modal
function addAs(i) {

    var m = document.getElementById("addAsModal" + i);
    bm = new bootstrap.Modal(m);
    bm.show();

}

//teacher add assignments
function addAssignment(id) {

    var gsid = id;
    var Asname = document.getElementById("Asname");
    var AddAs = document.getElementById("addLAssignment");
    var Sdate = document.getElementById("Sdate");
    var Edate = document.getElementById("Edate");
    var alertA = document.getElementById("alertA");

    var formData = new FormData();
    formData.append("Asname", Asname.value);
    formData.append("AddAs", AddAs.files[0]);
    formData.append("Sdate", Sdate.value);
    formData.append("Edate", Edate.value);
    formData.append("gsID", gsid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Asssignment added successfully") {
                alertA.classList = "alert alert-success input1 d-block";
                alertA.innerHTML = t;
                setTimeout(function() {
                    bm.hide();
                    reloadp();
                }, 2000);

            } else {
                alertA.classList = "alert alert-danger input1 d-block";
                alertA.innerHTML = t;
            }

        }
    };

    r.open("POST", "teacherAddAsProcess.php", true);
    r.send(formData);
}

//teacher view answers
function viewAnswers(x) {

    var asid = x;
    var loadA = document.getElementById("loadanswers");

    var formData = new FormData();
    formData.append("asid", asid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            loadA.innerHTML = t;
        }
    };
    r.open("POST", "teacherViewAnswers.php", true);
    r.send(formData);
}

//teacher add marks modal
function marksModal(i) {

    var m = document.getElementById("addMarksModal" + i);
    bm = new bootstrap.Modal(m);
    bm.show();

}

//clear alert in modal
function clearalertM(id) {
    document.getElementById("alertM" + id).classList = "d-none";
}


//teacher add marks
function addMarks(id) {

    var resultId = id;
    var marks = document.getElementById("addMarks" + id);
    var alertM = document.getElementById("alertM" + id);
    var asid = document.getElementById("asid" + id).innerHTML;

    var formData = new FormData();
    formData.append("marks", marks.value);
    formData.append("resultId", resultId);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Marks added successfully") {
                alertM.classList = "alert alert-success input1 d-block";
                alertM.innerHTML = t;

                setTimeout(function() {
                    bm.hide();

                    refreshT(asid); // refresh add marks table
                }, 2000);

            } else {
                alertM.classList = "alert alert-danger input1 d-block";
                alertM.innerHTML = t;
            }

        }
    };

    r.open("POST", "teacherAddMarksProcess.php", true);
    r.send(formData);
}

//refersh add marks
function refreshT(asid) {

    var aid = asid;
    var refershDiv = document.getElementById("refershDiv");

    var formData = new FormData();
    formData.append("asid", aid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            refershDiv.innerHTML = t;

        }
    };

    r.open("POST", "tebleRefresh.php", true);
    r.send(formData);

}

// Academic Officer log in
function signInAO() {

    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var remember = document.getElementById("remember");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("username", username.value);
    formData.append("password", password.value);
    formData.append("remember", remember.checked);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            // alert(t);

            if (t == "vcode") {

                var verificationModal = document.getElementById("verificationModal");
                k = new bootstrap.Modal(verificationModal);
                k.show();

            } else if (t == "second login") {

                username.value = "";
                password.value = "";
                window.location = "officerDashboard.php";
            } else if (t == "Invalid details") {

                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

                username.value = "";
                password.value = "";
                remember.checked = "";
            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

            }
        }
    };

    r.open("POST", "officerLoginProcess.php", true);
    r.send(formData);

}


//Academic Officer Verify
function OfficerVerify() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var vcode = document.getElementById("vcode");

    var alert = document.getElementById("alert1");

    var formData = new FormData();
    formData.append("username", username.value);
    formData.append("password", password.value);
    formData.append("vcode", vcode.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                k.hide();
                username.value = "";
                password.value = "";
                vcode.value = "";

                window.location = "officerDashboard.php";

            } else {

                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

            }
        }
    };
    r.open("POST", "officerVerifyProcess.php", true);
    r.send(formData);

}

//officer Logout proccess
function logOutAO() {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Success") {
                window.location = "officerLogin.php";
            }
        }
    };
    r.open("GET", "officerLogoutProcess.php", true);
    r.send();
}

//officer profile update
function officerUpdate() {

    var email = document.getElementById("email");
    var password = document.getElementById("password");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("email", email.value);
    formData.append("password", password.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "ok") {
                alert.classList = "alert alert-success input1 d-block";
                alert.innerHTML = "Profile Updated";
                setTimeout(function() {
                    location.reload();
                }, 2000);


            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };

    r.open("POST", "officerUpdateProfileProcess.php", true);
    r.send(formData);
}

//officer register students
function officerAddStudents() {

    var A_No = document.getElementById("sAdN");
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var grade = document.getElementById("grade");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("A_No", A_No.value);
    formData.append("fname", fname.value);
    formData.append("lname", lname.value);
    formData.append("email", email.value);
    formData.append("password", password.value);
    formData.append("grade", grade.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "ok") {
                alert.classList = "alert alert-success input1 d-block";
                alert.innerHTML = "Student Registration Success";
                setTimeout(function() {
                    location.reload();
                }, 2000);


            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };

    r.open("POST", "officerAddStudentsProcess.php", true);
    r.send(formData);
}

//offiser student results
function OSResults() {

    var load = document.getElementById("Oload");

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            load.innerHTML = t;
        }
    };
    r.open("GET", "officerViewMarks.php", true);
    r.send();
}

//officer search by subject
function Sname() {

    var subjectSelect = document.getElementById("subjectSelect");
    var AssignmentName = document.getElementById("searchAssignmentName");
    var Tload = document.getElementById("Tload");

    var formData = new FormData();
    formData.append("subjectSelect", subjectSelect.value);
    formData.append("AssignmentName", AssignmentName.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            Tload.innerHTML = t;
        }
    };
    r.open("POST", "officerSearchSubject.php", true);
    r.send(formData);

}

function showMarks(id) {
    var rid = id;
    var show = document.getElementById("show" + id);

    var formData = new FormData();
    formData.append("rid", rid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "success1") {
                show.className = "btn btn-info";
                show.innerHTML = "Show";
            } else if (t == "success2") {
                show.className = "btn btn-danger";
                show.innerHTML = "Hide";
            }
        }
    };
    r.open("POST", "officerShowMarks.php", true);
    r.send(formData);
}

// Admin log in
function signInAdmin() {

    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var remember = document.getElementById("remember");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("username", username.value);
    formData.append("password", password.value);
    formData.append("remember", remember.checked);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "ok") {

                username.value = "";
                password.value = "";
                window.location = "adminDashboard.php";

            } else if (t == "Invalid details") {

                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;

                username.value = "";
                password.value = "";
                remember.checked = "";

            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };

    r.open("POST", "adminLoginProcess.php", true);
    r.send(formData);

}

//admin Logout proccess
function logOutAd() {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Success") {
                window.location = "adminLogin.php";
            }
        }
    };
    r.open("GET", "adminLogoutProcess.php", true);
    r.send();
}

//admin profile update
function adminUpdate() {

    var email = document.getElementById("email");
    var password = document.getElementById("password");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("email", email.value);
    formData.append("password", password.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "ok") {
                alert.classList = "alert alert-success input1 d-block";
                alert.innerHTML = "Profile Updated";
                setTimeout(function() {
                    location.reload();
                }, 2000);


            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };

    r.open("POST", "adminUpdateProfileProcess.php", true);
    r.send(formData);
}

//admin manage Officer
function manageOfficer() {

    var Aload = document.getElementById("load");

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            Aload.innerHTML = t;
        }
    };
    r.open("GET", "adminManageOfficer.php", true);
    r.send();
}

function activeOfficer(id) {

    var Oid = id;
    var show = document.getElementById("active" + id);

    var formData = new FormData();
    formData.append("Oid", Oid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "success1") {
                show.className = "btn btn-primary btn2";
                show.innerHTML = "Active";
            } else if (t == "success2") {
                show.className = "btn btn-danger btn2";
                show.innerHTML = "Diactive";
            }
        }
    };
    r.open("POST", "manageOfficerProcess.php", true);
    r.send(formData);
}

//admin manage Teacher
function manageTeacher() {

    var Tload = document.getElementById("load");

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            Tload.innerHTML = t;
        }
    };
    r.open("GET", "adminManageteacher.php", true);
    r.send();
}

function activeTeacher(id) {

    var Tid = id;
    var show = document.getElementById("active" + id);

    var formData = new FormData();
    formData.append("Tid", Tid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "success1") {
                show.className = "btn btn-primary btn2";
                show.innerHTML = "Active";
            } else if (t == "success2") {
                show.className = "btn btn-danger btn2";
                show.innerHTML = "Diactive";
            }
        }
    };
    r.open("POST", "manageTeacherProcess.php", true);
    r.send(formData);
}

//admin manage Students
function manageStudents() {

    var Sload = document.getElementById("load");

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            Sload.innerHTML = t;
        }
    };
    r.open("GET", "adminManageStudents.php", true);
    r.send();
}

function activeStudent(id) {

    var Sid = id;
    var show = document.getElementById("active" + id);

    var formData = new FormData();
    formData.append("Sid", Sid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "success1") {
                show.className = "btn btn-primary btn2";
                show.innerHTML = "Active";
            } else if (t == "success2") {
                show.className = "btn btn-danger btn2";
                show.innerHTML = "Diactive";
            }
        }
    };
    r.open("POST", "manageStudentProcess.php", true);
    r.send(formData);
}

//admin add up student grade
function addUpGrade(id) {

    var Sid = id;
    var show = document.getElementById("gradeUp" + id);

    var formData = new FormData();
    formData.append("Sid", Sid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "Invalid student") {
                alert(t);

            } else {
                show.innerHTML = "Grade : " + t;
            }
        }
    };
    r.open("POST", "adminGradeUpStudentProcess.php", true);
    r.send(formData);

}

//admin register Officer
function registerOfficer() {

    window.location = "adminAddOfficer.php";
}

function adminAddOfficer() {

    var O_AdN = document.getElementById("OAdN");
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var Ograde = document.getElementById("selectGrade");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("O_AdN", O_AdN.value);
    formData.append("fname", fname.value);
    formData.append("lname", lname.value);
    formData.append("email", email.value);
    formData.append("password", password.value);
    formData.append("Ograde", Ograde.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "ok") {
                alert.classList = "alert alert-success input1 d-block";
                alert.innerHTML = "Officer Registration Success";
                setTimeout(function() {
                    location.reload();
                }, 2000);

            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };

    r.open("POST", "adminAddOfficerProcess.php", true);
    r.send(formData);

}

//admin register Teacher
function registerTeacher() {
    window.location = "adminAddTeacher.php";
}

function adminAddTeacher() {

    var T_AdN = document.getElementById("TAdN");
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var selectSection = document.getElementById("selectSection");


    var formData = new FormData();
    formData.append("T_AdN", T_AdN.value);
    formData.append("fname", fname.value);
    formData.append("lname", lname.value);
    formData.append("email", email.value);
    formData.append("password", password.value);
    formData.append("selectSection", selectSection.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "ok") {
                var m = T_AdN.value;
                addSub_M(m);

            } else {
                var alert = document.getElementById("alert");

                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }
        }
    };

    r.open("POST", "adminAddTeacherProcess.php", true);
    r.send(formData);

}

//teacher add sunjects & grade window
function addSub_M(m) {

    var Tid = m;
    var Sub_load = document.getElementById("load");

    var formData = new FormData();
    formData.append("Tid", Tid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            Sub_load.innerHTML = t;

        }
    };

    r.open("POST", "adminAddTeacherSub.php", true);
    r.send(formData);

}

//teacher add sunjects & grade
function adminAddTeacher_G_S(id) {

    var T_id = id;
    var S_G = document.getElementById("selectGrade&Subject");

    var alert = document.getElementById("alert");

    var formData = new FormData();
    formData.append("Tid", T_id);
    formData.append("s_g", S_G.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t = "ok") {

                alert.classList = "alert alert-success input1 d-block";
                alert.innerHTML = "Subject Added. you can add more Subjects";
                setTimeout(function() {
                    S_G.value = "0";
                }, 2000);

            } else {
                alert.classList = "alert alert-danger input1 d-block";
                alert.innerHTML = t;
            }

        }
    };

    r.open("POST", "adminAddTeacherSubProcess.php", true);
    r.send(formData);

}

//admin students Result
function studentsResult() {
    window.location = "adminViewResults.php";
}

//admin search by A/L subject
function sortResult() {

    var gradeSelect = document.getElementById("gradeSelect");
    var subjectSelect = document.getElementById("subjectSelect");
    var AssignmentName = document.getElementById("searchAssignmentName");
    var Adload = document.getElementById("Tload");

    var formData = new FormData();
    formData.append("gradeSelect", gradeSelect.value);
    formData.append("subjectSelect", subjectSelect.value);
    formData.append("AssignmentName", AssignmentName.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            Adload.innerHTML = t;
        }
    };
    r.open("POST", "adminSearchSubject.php", true);
    r.send(formData);

}

//admin search by not A/L subject
function sortResultAnother() {

    var gradeSelect = document.getElementById("gradeSelect");
    var subjectSelect = document.getElementById("subjectSelect");
    var AssignmentName = document.getElementById("searchAssignmentName");
    var Adload = document.getElementById("Tload");

    var formData = new FormData();
    formData.append("gradeSelect", gradeSelect.value);
    formData.append("subjectSelect", subjectSelect.value);
    formData.append("AssignmentName", AssignmentName.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            Adload.innerHTML = t;
        }
    };
    r.open("POST", "adminSearchSubjectAnother.php", true);
    r.send(formData);

}