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

if (isset($_POST['user_id']) && isset($_POST['room_id']) && isset($_POST['activity_date'])) {
	$user_id = $_POST['user_id'];
    $room_id = $_POST['room_id'];
    $activity_name = $_POST['activity_name'];
	$activity_date = $_POST['activity_date'];
    //$activity_date = new DateTime("{$activity_date}");
    //$activity_date = $activity_date->format('Y-m-d');
    $cutdate = explode("-", $activity_date);
    if (intval($cutdate[0])<1000 or intval($cutdate[0])>2024 or intval($cutdate[1])<1 or intval($cutdate[1])>12 or intval($cutdate[2])<1) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    } else if (intval($cutdate[1])>7 and intval($cutdate[1])%2==0 and intval($cutdate[2])>31) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    } else if (intval($cutdate[1])>7 and intval($cutdate[1])%2!=0 and intval($cutdate[2])>30) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    } else if (intval($cutdate[1])%2!=0 and intval($cutdate[2])>31) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    } else if (intval($cutdate[1])==2 and intval($cutdate[2])>29 and (intval($cutdate[0])%400==0 or (intval($cutdate[0])%4==0 and intval($cutdate[0])%100!=0))) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    } else if (intval($cutdate[2])>28) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    }
    
    $check_sql = "select * from activity
                    where room_id = {$room_id} and activity_date='{$activity_date}';";
    $result = $conn->query($check_sql);
    if ($result->num_rows > 0) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    }

    $check_sql = "select * from room
                    where room_id = {$room_id};";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    }
    $check_sql = "select * from user
                    where user_id = {$user_id};";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    }
    
    $create_sql = "insert into activity
                    values ({$user_id},{$room_id},'{$activity_name}','{$activity_date}');";
    $result = $conn->query($create_sql);
    $check_sql = "select * from activity
                    where user_id={$user_id} and room_id={$room_id} and activity_name='{$activity_name}' and activity_date='{$activity_date}';";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    }

    $message = "新增成功";
	$location = "create.php?msg=" . urlencode($message);
	header("Location: " . $location);
}else{
	$message = "新增失敗";
    $location = "create.php?msg=" . urlencode($message);
    header("Location: " . $location);
}
				
?>