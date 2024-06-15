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
$dvd_id_o = $_POST['dvd_id_o'];
$queue_o = $_POST['queue_o'];
$estimation_date_o = $_POST['estimation_date_o'];
$estimation_date_o = new DateTime("{$estimation_date_o}");
$estimation_date_o = $estimation_date_o->format('Y-m-d');
$user_id = $_POST['user_id'];
$dvd_id = $_POST['dvd_id'];
$queue = $_POST['queue'];
$estimation_date = $_POST['estimation_date'];
$estimation_date = new DateTime("{$estimation_date}");
$estimation_date = $estimation_date->format('Y-m-d');

$update_sql = "update dvd_reservation
                set user_id={$user_id}, dvd_id={$dvd_id}, queue={$queue}, estimation_date='{$estimation_date}'
                where user_id={$user_id_o} and dvd_id={$dvd_id_o} and estimation_date='{$estimation_date_o}';";
$result = $conn->query($update_sql);
$check_sql = "select * from dvd_reservation
                where user_id={$user_id} and dvd_id={$dvd_id} and queue={$queue} and estimation_date='{$estimation_date}';";
$result = $conn->query($check_sql);

if ($result->num_rows == 0) {
    $message = "修改失敗";
    $location = "updateDVDRes_details.php?msg=" . urlencode($message);
    header("Location: " . $location);
} else {
    $message = "修改成功";
    $location = "update.php?msg=" . urlencode($message);
    header("Location: " . $location);
}

				
?>
