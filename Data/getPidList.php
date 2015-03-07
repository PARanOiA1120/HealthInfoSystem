<?php
/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 3/1/15
 * Time: 8:26 PM
 */

$username="root";
$password="";
$database="HealthInformationSystem";

$conn=mysql_connect('127.0.0.1',$username,$password);
@mysql_select_db($database, $conn) or die( "Unable to select HealthInformationSystem");

$result = mysql_query("SELECT patientId FROM Patient");
$to_encode = array();
while($row = mysql_fetch_assoc($result)) {
    $to_encode[] = $row;
}
//output header
echo json_encode($to_encode);