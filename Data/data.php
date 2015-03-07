<?php
/**
 * Created by PhpStorm.
 * User: Ariel Xin
 * Date: 2/28/15
 * Time: 12:34 PM
 */

$username="root";
$password="";
$database="healthmessagesexchange2";
$database2="HealthInformationSystem";

mysql_connect('127.0.0.1',$username,$password)or die(mysql_error());
echo "Connected to MySQL<br>";

/** import data into Guardians table*/
@mysql_select_db($database) or die( mysql_error());
$result = mysql_query("SELECT GuardianNo, FirstName, LastName, phone, address,city, state, zip  FROM messages");
@mysql_select_db($database2) or die( mysql_error());
while ($row = mysql_fetch_array($result)) {
    $import=mysql_query("INSERT INTO Guardians VALUES ('".$row{'GuardianNo'}."', '".$row{'FirstName'}."', '".$row{'LastName'}
        ."', '".$row{'phone'}."', '".$row{'address'}."', '".$row{'city'}."', '".$row{'state'}."', '".$row{'zip'}."')
        ON DUPLICATE KEY UPDATE GuardianNo = GuardianNo");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}

/** import data into InsuranceCompany table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT PayerId, messages.Name FROM messages");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    $import=mysql_query("INSERT INTO InsuranceCompany VALUES ('".$row{'PayerId'}."', '".$row{'Name'}."')
    ON DUPLICATE KEY UPDATE PayerId = PayerId");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}

/** import data into Patient table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT patientId, GivenName, FamilyName, BirthTime, GuardianNo, Relationship, providerId,
                              PayerId, PolicyType, Purpose, PolicyHolder FROM messages");
@mysql_select_db($database2) or die(mysql_error());
date_default_timezone_set('America/Los_Angeles');
$date = date('j/n/Y h:i:s a', time());
while ($row = mysql_fetch_array($result)) {
    if($row{'PolicyHolder'}=="Patient's son")
        $policyholder="Patient\\'son";
    else
        $policyholder=$row{'PolicyHolder'};
    $import=mysql_query("INSERT INTO Patient VALUES ('".$row{'patientId'}."', '".$row{'GivenName'}."', '".$row{'FamilyName'}
        ."', '".$row{'BirthTime'}."', NULL, NULL, '".$row{'GuardianNo'}."', '".$row{'Relationship'}."', '".$row{'providerId'}."', '".$row{'PayerId'}
        ."', '".$row{'PolicyType'}."', '".$row{'Purpose'}."', '".$policyholder."', '".$date."') ON DUPLICATE KEY UPDATE patientId = patientId");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}

/** import data into Author table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT AuthorId, AuthorTitle, AuthorFirstName, AuthorLastName FROM messages");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    $import=mysql_query("INSERT INTO Author VALUES ('".$row{'AuthorId'}."', '".$row{'AuthorTitle'}."', '".
        $row{'AuthorFirstName'}."', '".$row{'AuthorLastName'}."') ON DUPLICATE KEY UPDATE AuthorId=AuthorId");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}

/** import data into Author_Records_Patient table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT AuthorId, patientId, ParticipatingRole FROM messages");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    $import=mysql_query("INSERT INTO Author_Records_Patient VALUES ('".$row{'AuthorId'}."', '".$row{'patientId'}."', '".
        $row{'ParticipatingRole'}."') ON DUPLICATE KEY UPDATE AuthorId=AuthorId");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}

/** import data into Allergies table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT Id, Substance FROM messages");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    if($row{'Substance'} == null)
        $substance="NULL";
    else
        $substance="'".$row{'Substance'}."'";
    $import=mysql_query("INSERT INTO Allergies VALUES ('".$row{'Id'}."', ". $substance.")
    ON DUPLICATE KEY UPDATE  Allergy_id = Allergy_id");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}


/** import data into Patient_has_Allergies table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT patientId, Id, Reaction, Status FROM messages");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    if($row{'Reaction'} == null)
        $reaction="NULL, NULL";
    else
        $reaction="'".$row{'Reaction'}."' , '".$row{'Status'}. "'";
    $import = mysql_query("INSERT INTO Patient_has_Allergies VALUES ('" . $row{'patientId'} .
        "', '" . $row{'Id'} . "', ".$reaction.")ON DUPLICATE KEY UPDATE patientId = patientId , Allergy_id = Allergy_id");
    if (!$import)
        die('Invalid query: ' . mysql_error());
}


/** import data into Test table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT patientId, LabTestResultId, PatientVisitId, LabTestType, TestResultValue,
                        ReferenceRangeHigh, ReferenceRangeLow, LabTestPerformedDate FROM messages");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    $import=mysql_query("INSERT INTO LabTestReport VALUES ('".$row{'patientId'}."', '".$row{'LabTestResultId'}."', '".
        $row{'PatientVisitId'}."', '".$row{'LabTestType'}."', '".$row{'TestResultValue'}."', '".$row{'ReferenceRangeHigh'}.
        "', '".$row{'ReferenceRangeLow'}."', '".$row{'LabTestPerformedDate'}."')
         ON DUPLICATE KEY UPDATE patientId=patientId, LabTestResultId=LabTestResultId");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}


/** import data into Activity table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT DISTINCT Activity FROM messages WHERE Activity IS NOT NULL");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    $import=mysql_query("INSERT INTO Activity VALUES ('".$row{'Activity'}."') ON DUPLICATE KEY UPDATE Activity = Activity");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}

/** import data into patient_plans_activity table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT patientId, PlanId, Activity, ScheduledDate FROM messages WHERE Activity IS NOT NULL");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    $import=mysql_query("INSERT INTO patient_plans_activity VALUES ('".$row{'patientId'}."', '".$row{'PlanId'}."', '".
        $row{'Activity'}."', '".$row{'ScheduledDate'}."') ON DUPLICATE KEY UPDATE patientId=patientId, PlanId=PlanId");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}


/** import data into relatives table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT DISTINCT RelativeId, age, Diagnosis FROM messages");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    $import=mysql_query("INSERT INTO relatives VALUES ('".$row{'RelativeId'}."', '".$row{'age'}."', '".
        $row{'Diagnosis'}."' ) ON DUPLICATE KEY UPDATE  RelativeId= RelativeId");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}

/** import data into Patient_has_FamilyHistory table */
@mysql_select_db($database) or die(mysql_error());
$result = mysql_query("SELECT patientId, RelativeId, Relation FROM messages");
@mysql_select_db($database2) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
    $import=mysql_query("INSERT INTO Patient_has_FamilyHistory VALUES ('".$row{'patientId'}."', '".$row{'RelativeId'}."', '".
        $row{'Relation'}."' ) ON DUPLICATE KEY UPDATE  patientId=patientId, RelativeId= RelativeId");
    if(!$import)
        die('Invalid query: ' . mysql_error());
}

mysql_close();
