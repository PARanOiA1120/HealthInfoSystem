<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, td, th {
            border: 1px solid black;
            padding: 5px;
        }
        th {text-align: left;}
    </style>
</head>
<body>

<?php
/**
 * Created by PhpStorm.
 * User: Ariel Xin
 * Date: 3/6/15
 * Time: 7:08 PM
 */
$pid = intval($_GET['PatientID']);

$username="root";
$password="";
$database="HealthInformationSystem";

$conn=mysql_connect('127.0.0.1',$username,$password);
@mysql_select_db($database, $conn) or die( "Unable to select HealthInformationSystem");
?>

<form>
    <input type="button" value="Edit" onclick="location.href = '../Interface/Patient.html'"/>
    (Click to edit your profile!)
</form>


<?php
/**Show patient info*/
$result = mysql_query("SELECT GivenName, FamilyName, BirthTime, suffix, gender,
          xmlCreationDate FROM Patient WHERE patientId='".$pid."'");
echo "<h1> Patient Profile </h1>
    <h2> Patient Information </h2>
    <table><tr><th>GivenName</th><th>FamilyName</th><th>Suffix</th>
    <th>Gender</th><th>BirthTime</th><th>Last Update</th></tr>";
while($row = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['GivenName'] . "</td>";
    echo "<td>" . $row["FamilyName"] . "</td>";
    echo "<td>" . $row['suffix'] . "</td>";
    echo "<td>" . $row['gender'] . "</td>";
    echo "<td>" . $row['BirthTime'] . "</td>";
    echo "<td>" . $row['xmlCreationDate'] . "</td>";
    echo "</tr>";
}
echo "</table>";

/**Show guardian info, each patient has exactly one guardian*/
$result = mysql_query("SELECT P.GuardianNo, Relationship, FirstName, LastName, phone, address, city, state, zip
                        FROM Patient P, Guardians G
                        WHERE P.GuardianNo = G.GuardianNo AND P.patientId='".$pid."'");
echo " <h2> Guardian Information </h2>
    <table><tr><th>GuardianNo</th><th>Relationship</th><th>FirstName</th><th>FamilyName</th>
    <th>Phone</th><th>Address</th><th>City</th><th>State</th><th>Zip</th></tr>";
while($row = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['GuardianNo'] . "</td>";
    echo "<td>" . $row['Relationship'] . "</td>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['phone'] . "</td>";
    echo "<td>" . $row['address'] . "</td>";
    echo "<td>" . $row['city'] . "</td>";
    echo "<td>" . $row['state'] . "</td>";
    echo "<td>" . $row['zip'] . "</td>";
    echo "</tr>";
}
echo "</table>";

/**Show doctor information, each patient can has more than one or no doctor*/
$result = mysql_query("SELECT A.AuthorId, AuthorTitle, AuthorFirstName, AuthorLastName, ParticipatingRole
                        FROM Author A, Author_Records_Patient P
                        WHERE P.AuthorId = A.AuthorId AND P.patientId='".$pid."'");
echo " <h2> Doctor Information </h2>
    <table><tr><th>AuthorId</th><th>Title</th><th>FirstName</th><th>LastName</th>
    <th>ParticipatingRole</th></tr>";
while($row = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['AuthorId'] . "</td>";
    echo "<td>" . $row['AuthorTitle'] . "</td>";
    echo "<td>" . $row['AuthorFirstName'] . "</td>";
    echo "<td>" . $row['AuthorLastName'] . "</td>";
    echo "<td>" . $row['ParticipatingRole'] . "</td>";
    echo "</tr>";
}
echo "</table>";

/**Show provider information, each patient has exactly one provider*/
$result = mysql_query("SELECT I.PayerId, I.Name, providerId, PolicyType, Purpose, PolicyHolder
                        FROM InsuranceCompany I, Patient P
                        WHERE P.PayerId = I.PayerId AND P.patientId='".$pid."'");
echo " <h2> Provider Information </h2>
    <table><tr><th>PayerID</th><th>Name</th><th>ProviderID</th><th>Policy Type</th>
    <th>Purpose</th><th>Policy Holder</th></tr>";
while($row = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['PayerId'] . "</td>";
    echo "<td>" . $row['Name'] . "</td>";
    echo "<td>" . $row['providerId'] . "</td>";
    echo "<td>" . $row['PolicyType'] . "</td>";
    echo "<td>" . $row['Purpose'] . "</td>";
    echo "<td>" . $row['PolicyHolder'] . "</td>";
    echo "</tr>";
}
echo "</table>";

/**Show Lab Test Report information*/
$result = mysql_query("SELECT LabTestResultId, PatientVisitId, LabTestType, TestResultValue,ReferenceRangeHigh,
                        ReferenceRangeLow, LabTestPerformedDate FROM LabTestReport WHERE patientId='".$pid."'");
echo " <h2> Lab Test Report </h2>
    <table><tr><th>Test Report ID</th><th>Visit ID</th><th>Type</th><th>Result</th><th>Reference Value(High)</th>
    <th>Reference Value(Low)</th><th>Performed Date</th></tr>";
while($row = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td><div contenteditable>" . $row['LabTestResultId'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['PatientVisitId'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['LabTestType'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['TestResultValue'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['ReferenceRangeHigh'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['ReferenceRangeLow'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['LabTestPerformedDate'] . "</div></td>";
    echo "</tr>";
}
echo "</table>";


/**Show Family History information*/
$result = mysql_query("SELECT R.RelativeId, Relation, age, Diagnosis
                        FROM relatives R, Patient_has_FamilyHistory P
                        WHERE R.RelativeId = P.RelativeId AND P.patientId='".$pid."'");
echo " <h2> Family History </h2>
    <table><tr><th>RelativeId</th><th>Relation</th><th>Age</th><th>Diagnosis</th></tr>";
while($row = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td><div contenteditable>" . $row['RelativeId'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['Relation'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['age'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['Diagnosis'] . "</div></td>";
    echo "</tr>";
}
echo "</table>";

/**Show Allergy information, this table should be editable*/
$result = mysql_query("SELECT A.Allergy_id, Substance, Reaction, Status
                        FROM Allergies A, Patient_has_Allergies P
                        WHERE P.Allergy_id = A.Allergy_id AND P.patientId='".$pid."'");
echo " <h2> Allergy </h2>
    <table><tr><th>AllergyID</th><th>Substance</th><th>Reaction</th><th>Status</th></tr>";
while($row = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td><div contenteditable>" . $row['Allergy_id'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['Substance'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['Reaction'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['Status'] . "</div></td>";
    echo "</tr>";
}
echo "</table>";


/**Show Plan information, this table should be editable*/
$result = mysql_query("SELECT PlanId, Activity, ScheduledDate FROM patient_plans_activity
                        WHERE patientId='".$pid."'");
echo " <h2> Plan </h2>
    <table><tr><th>PlanID</th><th>Plan</th><th>ScheduledDate</th></tr>";
while($row = mysql_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td><div contenteditable>" . $row['PlanId'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['Activity'] . "</div></td>";
    echo "<td><div contenteditable>" . $row['ScheduledDate'] . "</div></td>";
    echo "</tr>";
}
echo "</table>";

?>
</body>
</html>