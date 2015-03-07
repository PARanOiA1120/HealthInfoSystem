/**
 * Created by Ariel Xin on 3/1/15.
 */

var username;

var main = function() {
    var check = html5_storage();
};

function displayLogin(roles) {
    $("#logindiv").css("display", "block");
    username = roles;
    return document.getElementById("logindiv").style.display;
};

//read php encoded JSON file
var xmlhttp = new XMLHttpRequest();
var url = "http://localhost/HealthInfoSystem/Data/getPidList.php";
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        myFunction(xmlhttp.responseText);
    }
}
xmlhttp.open("GET", url, true);
xmlhttp.send();

//put all pids in an array
var idList = [];
function myFunction(response) {
    var arr = JSON.parse(response);
    var i;
    for(i = 0; i < arr.length; i++) {
        idList[i] = arr[i].patientId;
    }
}

function loginButton() {
    var password = $("#password").val();
    var passed = false;

    //Patient: password = patientId
    if(username=="Patient") {
        var i;
        for(i = 0; i < idList.length; i++) {
            if(password == idList[i]) passed=true;
        }
    }
    //Author/Doctor: password = "Author"
    if(username=="Doctor"){
        if(password=="doctor") passed=true;
    }
    //Administrator: password = "Administrator"
    else {
        if(password == "admin") passed = true;
    }

    if(passed) {
        localStorage["password"] = password;
        if(username=="Patient")
            window.location.href = "../Data/Patient.php?PatientID="+password;
        if(username=="Doctor")
            window.location.href = "Doctor.html";
        if(username=="Administrator")
            window.location.href = "Administrator.html";
    }
    else {
        alert("Wrong Password");
        localStorage["password"] = "";
        document.getElementById("password").value = "";
    }
    return localStorage["password"];
};

function cancelButton() {
    $("#logindiv").css("display", "none");
    document.getElementById("password").value = "";
    return document.getElementById("logindiv").style.display, document.getElementById("password").value;
};

function html5_storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        // no native support for HTML5 storage
        alert("This browser doesn't support some functionalities of this website, please try using another browser.");
        return false;
    }
};

$(document).ready(main);