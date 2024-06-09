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
$user_id = $_POST['user_id'];
$dvd_id = $_POST['dvd_id'];
$queue = $_POST['queue'];
$estimation_date = $_POST['estimation_date'];

$update_sql = "update dvd_reservation
                set user_id={$user_id}, dvd_id={$dvd_id}, queue={$queue}, estimation_date='{$estimation_date}'
                where user_id={$user_id_o} and dvd_id={$dvd_id_o} and estimation_date='{$estimation_date_o}';";
$result = $conn->query($update_sql);
$check_sql = "select * from dvd_reservation
                where user_id={$user_id} and dvd_id={$dvd_id} and queue={$queue} and estimation_date='{$estimation_date}';";
$result = $conn->query($check_sql);

if ($result->num_rows == 0) {
    echo "<h2 align='center'><font color='#5b554e'>修改失敗!!</font></h2>";
    echo "<li><a href=\"updateDVDRes_details.php\"><font color='#5b554e'>回到上一頁</font></a></li>";
} else {
    echo "<h2 align='center'><font color='#5b554e'>修改成功!!</font></h2>";
    echo "<li><a href=\"update.php\"><font color='#5b554e'>回到上一頁</font></a></li>";
}

				
?>
