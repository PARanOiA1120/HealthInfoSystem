<?php

$username = "root";
$password = "";
$dbname = "HealthInformationSystem";
$server = "127.0.0.1";

// Create connection
$pid = intval($_GET['PatientID']);

$conn = new mysqli($server, $username, $password, $dbname) or die(mysql_error());
// Check connection
$patientInfo = array();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT Patient_has_Allergies.Allergy_id, Substance, Reaction, Patient_has_Allergies.Status
FROM Patient_has_Allergies INNER JOIN Allergies WHERE patientId =$pid AND Patient_has_Allergies.Allergy_id = Allergies.Allergy_id";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $patientInfo[] = $row;
    }
} else {
    echo "0 results";
}

$sql2 = "SELECT PlanId, Activity, ScheduledDate FROM patient_plans_activity WHERE patientId = $pid";
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    // output data of each row
    while($row = $result2->fetch_assoc()) {
        $patientInfo[] = $row;
    }
} else {
    echo "0 results";
}


echo json_encode($patientInfo);