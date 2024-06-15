<?php

// ******** update your personal settings ******** 
$servername = "140.122.184.129:3310";
$username = "team4";
$password = "4pI@3uqfCfzW09Te";
$dbname = "team4";

// Connecting to and selecting a MySQL database
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit();
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$user_id_o = $_POST['user_id_o'];
$room_id_o = $_POST['room_id_o'];
$staff_id_o = $_POST['staff_id_o'];
$activity_name_o = $_POST['activity_name_o'];
$activity_date_o = $_POST['activity_date_o'];
$activity_date_o = new DateTime("{$activity_date_o}");
$activity_date_o = $activity_date_o->format('Y-m-d');
$user_id = $_POST['user_id'];
$room_id = $_POST['room_id'];
$activity_name = $_POST['activity_name'];
if ($activity_name == "") {
    $activity_name = "-";
}
$activity_date = $_POST['activity_date'];
$activity_date = new DateTime("{$activity_date}");
$activity_date = $activity_date->format('Y-m-d');

$update_sql = "update activity
                set user_id={$user_id}, room_id={$room_id}, activity_name='{$activity_name}', activity_date='{$activity_date}'
                where user_id={$user_id_o} and room_id={$room_id_o} and activity_date='{$activity_date_o}';";
$result = $conn->query($update_sql);
$check_sql = "select * from activity
                where user_id={$user_id} and room_id={$room_id} and activity_name='{$activity_name}' and activity_date='{$activity_date}';";
$result = $conn->query($check_sql);

if ($result->num_rows == 0) {
    $message = "修改失敗";
    $location = "updateAct_details.php?msg=" . urlencode($message);
    header("Location: " . $location);
} else {
    $message = "修改成功";
    $location = "update.php?msg=" . urlencode($message);
    header("Location: " . $location);
}

				
?>
