
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HealthInformationSystem";
$id = "12430";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql1 = "SELECT G.GuardianNo, G.FirstName, G.LastName, G.phone, G.address, G.city, G.state, G.zip FROM Guardians G, Patient P WHERE P.GuardianNo = G.GuardianNo AND P.PatientId = $id";
$result1 = $conn->query($sql1);
echo "<table border='1' align='center'>
    <caption>Guardian Table</caption>
    <tr>
        <th>Guardian Number</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Zip Code</th>
    </tr>";
if ($result1->num_rows > 0) {
    // output data of each row
    while($row = $result1->fetch_assoc()) {
        echo "<tr><td>". $row["GuardianNo"]. "</td><td>"
            . $row["FirstName"]. "</td><td>"
            . $row["LastName"]. "</td><td>"
            . $row["phone"]. "</td><td>"
            . $row["address"]. "</td><td>"
            . $row["city"]. "</td><td>"
            . $row["state"]. "</td><td>"
            . $row["zip"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$sql = "SELECT PatientId, GivenName, FamilyName, BirthTime, suffix, gender, GuardianNo, Relationship FROM Patient WHERE PatientId = $id";
$result = $conn->query($sql);
echo "<table border='1' align='center'>
    <caption> Patient Table</caption>
    <tr>
        <th>Patient ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Birthday</th>
        <th>Suffix</th>
        <th>Gender</th>
        <th>Guardian Number</th>
        <th>Relationship</th>
    </tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>". $row["PatientId"]. "</td><td>"
            . $row["GivenName"]. "</td><td>"
            . $row["FamilyName"]. "</td><td>"
            . $row["BirthTime"]. "</td><td>"
            . $row["suffix"]. "</td><td>"
            . $row["gender"]. "</td><td>"
            . $row["GuardianNo"]. "</td><td>"
            . $row["Relationship"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}


$conn->close();
?>



</body>
</html>>