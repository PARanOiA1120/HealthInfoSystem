<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "HealthInformationSystem";
$pid = intval($_GET['PatientID']);
$inputJSON = file_get_contents('php://input');
$input= json_decode( $inputJSON, TRUE ); //convert JSON into array

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


foreach ($input as $value) {
    //print_r($value);
    if (array_key_exists("Allergy_id", $value)) {
        $Allergy_id = $value["Allergy_id"];
        $Substance = $value["Substance"];
        $Reaction = $value["Reaction"];
        $Status = $value["Status"];
        $sql = "UPDATE Patient_has_Allergies JOIN Allergies ON Patient_has_Allergies.Allergy_id = Allergies.Allergy_id SET Substance ='" . $Substance . "', Reaction='" . $Reaction . "', Status='" . $Status . "' WHERE Patient_has_Allergies.Allergy_id = '" . $Allergy_id . "' AND Patient_has_Allergies.patientId = '" . $pid . "'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

    } else {
        $PlanId = $value["PlanId"];
        $Activity = $value["Activity"];
        $ScheduledDate = $value["ScheduledDate"];
        $sql2 = "UPDATE patient_plans_activity SET ScheduledDate='" . $ScheduledDate . "' WHERE PlanId = '" . $PlanId . "' AND patientId = '" . $pid . "'";
        if ($conn->query($sql2) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

    }
}
$conn->close();