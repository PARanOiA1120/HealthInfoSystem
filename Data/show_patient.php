
<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "HealthInformationSystem";

// Create connection
$pid = intval($_GET['PatientID']);
$conn = new mysqli($servername, $username, $password, $dbname) or die(mysql_error());
// Check connection
$patientInfo = array();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT patientId, GivenName, FamilyName, BirthTime, suffix,
gender, GuardianNo, Relationship FROM Patient WHERE patientId =$pid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $patientInfo[] = $row;
    }

} else {
    echo "0 results";
}
echo json_encode($patientInfo);








