<?php

// ******** update your personal settings ******** 
$servername = "140.122.184.129:3310";
$username = "team4";
$password = "4pI@3uqfCfzW09Te";
$dbname = "team4";
/*$servername = "localhost";
$username = "root";
$password = "";
$dbname = "";*/

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
$user_id = $_POST['user_id'];
$room_id = $_POST['room_id'];
$staff_id = $_POST['staff_id'];
$activity_name = $_POST['activity_name'];
$activity_date = $_POST['activity_date'];

$update_sql = "update activity
                set user_id={$user_id}, room_id={$room_id}, staff_id={$staff_id}, activity_name='{$activity_name}', activity_date='{$activity_date}'
                where user_id={$user_id_o} and room_id={$room_id_o} and activity_date='{$activity_date_o}';";
$result = $conn->query($update_sql);
$check_sql = "select * from activity
                where user_id={$user_id} and room_id={$room_id} and staff_id={$staff_id} and activity_name='{$activity_name}' and activity_date='{$activity_date}';";
$result = $conn->query($check_sql);

if ($result->num_rows == 0) {
    echo "<h2 align='center'><font color='#5b554e'>修改失敗!!</font></h2>";
    echo "<li><a href=\"updateAct_details.php\"><font color='#5b554e'>回到上一頁</font></a></li>";
} else {
    echo "<h2 align='center'><font color='#5b554e'>修改成功!!</font></h2>";
    echo "<li><a href=\"update.php\"><font color='#5b554e'>回到上一頁</font></a></li>";
}

				
?>
