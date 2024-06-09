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

$user_id = $_GET['user_id'];
$room_id = $_GET['room_id'];
$activity_date = $_GET['activity_date'];

$update_sql = "delete from activity
                where user_id={$user_id} and room_id={$room_id} and activity_date='{$activity_date}';";
$result = $conn->query($update_sql);
$check_sql = "select * from activity
                where user_id={$user_id} and room_id={$room_id} and activity_date='{$activity_date}';";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    echo "<h2 align='center'><font color='#5b554e'>刪除失敗!!</font></h2>";
} else {
    echo "<h2 align='center'><font color='#5b554e'>刪除成功!!</font></h2>";
}
echo "<li><a href=\"delete.php\"><font color='#5b554e'>回到上一頁</font></a></li>";

				
?>
