
<?php
$pid = intval($_GET['PatientID']);

$username="root";
$password="";
$database="HealthInformationSystem";

$conn=mysql_connect('127.0.0.1',$username,$password);
@mysql_select_db($database, $conn) or die( "Unable to select HealthInformationSystem");
/**Show patient info*/


$result = mysql_query("SELECT patientId, GivenName, FamilyName, BirthTime, suffix, gender, Patient.GuardianNo, Relationship,
FirstName, LastName, phone, address, city, state, zip FROM Patient INNER JOIN Guardians WHERE patientId =$pid AND Patient.GuardianNo = Guardians.GuardianNo");

$patientInfo = array();
$patientInfo2 = array();
while ($row = mysql_fetch_array($result)) {
    $fn = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row["FamilyName"]);
    $ln = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row["LastName"]);
    $addr = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row["address"]);

    $patientInfo["GivenName"] =   $row["GivenName"];
    $patientInfo["FamilyName"] = $fn;
    $patientInfo["BirthTime"] = $row["BirthTime"];
    $patientInfo["suffix"] =  $row["suffix"];
    $patientInfo["gender"] = $row["gender"];
    $patientInfo["GuardianNo"] =  $row["GuardianNo"];
    $patientInfo["Relationship"] =  $row["Relationship"];
    $patientInfo["FirstName"] =  $row["FirstName"];
    $patientInfo["LastName"] =  $ln;
    $patientInfo["phone"] =  $row["phone"];
    $patientInfo["address"] = $addr;
    $patientInfo["city"] =  $row["Relationship"];
    $patientInfo["state"] =  $row["Relationship"];
    $patientInfo["zip"] =  $row["Relationship"];
    $patientInfo2[]=$row;

}
echo json_encode($patientInfo);
//echo json_encode($patientInfo2);

// Check connection
/**$result = mysql_query("SELECT patientId, GivenName, FamilyName, BirthTime, suffix, gender, Patient.GuardianNo, Relationship,
FirstName, LastName, phone, address, city, state, zip FROM Patient INNER JOIN Guardians WHERE patientId ='12444'
AND Patient.GuardianNo = Guardians.GuardianNo");

// output data of each row
$patientInfo = array();
while ($row = mysql_fetch_array($result)) {
    $patientInfo[] = $row;
}
echo json_encode($patientInfo);*/








