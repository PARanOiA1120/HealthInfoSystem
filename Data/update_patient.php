<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "HealthInformationSystem";

$inputJSON = file_get_contents('php://input');
$input= json_decode( $inputJSON, TRUE ); //convert JSON into array
$patientId = $input["patientId"];
$GivenName = $input["GivenName"];
$FamilyName = $input["FamilyName"];
$BirthTime = $input["BirthTime"];
$suffix = $input["suffix"];
$gender = $input["gender"];
$GuardianNo = $input["GuardianNo"];
$Relationship = $input["Relationship"];
#print_r($input["GivenName"]);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE Patient SET GivenName ='".$GivenName."', FamilyName='".$FamilyName."', BirthTime='".
$BirthTime."', suffix='".$suffix."', gender='".$gender."', Relationship='".$Relationship."' WHERE patientId = '".$patientId."'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
