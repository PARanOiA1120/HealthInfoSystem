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
$FirstName = $input["FirstName"];
$LastName = $input["LastName"];
$phone = $input["phone"];
$address = $input["address"];
$city = $input["city"];
$state = $input["state"];
$zip = $input["zip"];

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

$sql2 = "UPDATE Guardians SET FirstName ='".$FirstName."', LastName='".$LastName."', phone='".$phone."', address='".$address."', city='".$city."', state='".$state."', zip='".$zip."' WHERE GuardianNo = '".$GuardianNo."'";
if ($conn->query($sql2) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
$conn->close();