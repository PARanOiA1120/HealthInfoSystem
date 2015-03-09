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
 * Date: 3/2/15
 * Time: 5:20 PM
 */

$q = intval($_GET['q']);

$username="root";
$password="";
$database="HealthInformationSystem";

$conn=mysql_connect('127.0.0.1',$username,$password);
@mysql_select_db($database, $conn) or die( "Unable to select HealthInformationSystem");


/**View number of patients for each type of allergy (substance)*/
if($q == '1'){
    $result = mysql_query("SELECT P.Allergy_id, A.Substance, COUNT(*) AS NumOfPatient
                            FROM Patient_has_Allergies P, Allergies A
                            WHERE P.Allergy_id = A.Allergy_id
                            GROUP BY Allergy_id");
    echo "<table><tr>
    <th>AllergyID</th>
    <th>Substance</th>
    <th>Number of Patients</th></tr>";
    while($row = mysql_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['Allergy_id'] . "</td>";
        echo "<td>" . $row['Substance'] . "</td>";
        echo "<td>" . $row['NumOfPatient'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

/**List the patients who have more than one allergy*/
if($q == '2') {
    $result = mysql_query("SELECT P.patientId, P.GivenName, P.FamilyName, COUNT(*) AS NumOfAllergies
                            FROM Patient P, Patient_has_Allergies A
                            WHERE P.patientId = A.patientId
                            GROUP BY P.patientId
                            HAVING COUNT(*)>1");
    echo "<table><tr>
    <th>PatientId</th>
    <th>GivenName</th>
    <th>FamilyName</th>
    <th>Number of Allergies</th></tr>";
    while($row = mysql_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['patientId'] . "</td>";
        echo "<td>" . $row['GivenName'] . "</td>";
        echo "<td>" . $row['FamilyName'] . "</td>";
        echo "<td>" . $row['NumOfAllergies'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

/**List the patients who have a plan for surgery today.*/
if($q == '3') {
    date_default_timezone_set('America/Los_Angeles');
    $date = date('n/j/Y', time());
    $date="'".$date."%'";

    $result = mysql_query("SELECT P.patientId, A.PlanId, P.GivenName, P.FamilyName, A.ScheduledDate
                            FROM Patient P, patient_plans_activity A
                            WHERE P.patientId=A.patientId AND A.Activity='Surgery' AND A.ScheduledDate LIKE".$date);

    echo "<table><tr>
    <th>PatientId</th>
    <th>PlanId</th>
    <th>GivenName</th>
    <th>FamilyName</th>
    <th>Surgery Time</th></tr>";
    while($row = mysql_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['patientId'] . "</td>";
        echo "<td>" . $row['PlanId'] . "</td>";
        echo "<td>" . $row['GivenName'] . "</td>";
        echo "<td>" . $row['FamilyName'] . "</td>";
        echo "<td>" . $row['ScheduledDate'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

}

/**Identify authors with more than one patient.*/
if($q == '4') {
    $result = mysql_query("SELECT A.AuthorId, A.AuthorTitle, A.AuthorFirstName, A.AuthorLastName, COUNT(*) AS NumOfPatient
                            FROM Author_Records_Patient P, Author A
                            WHERE P.AuthorId=A.AuthorId
                            GROUP BY A.AuthorId
                            HAVING COUNT(*)>1;");

    echo "<table><tr>
    <th>AuthorId</th>
    <th>AuthorTitle</th>
    <th>AuthorFirstName</th>
    <th>AuthorLastName</th>
    <th>Number of Patients</th></tr>";
    while($row = mysql_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['AuthorId'] . "</td>";
        echo "<td>" . $row['AuthorTitle'] . "</td>";
        echo "<td>" . $row['AuthorFirstName'] . "</td>";
        echo "<td>" . $row['AuthorLastName'] . "</td>";
        echo "<td>" . $row['NumOfPatient'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

?>
</body>
</html>