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

if (isset($_POST['user_id']) && isset($_POST['book_id']) && isset($_POST['estimation_date'])) {
	$user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $queue = $_POST['queue'];
    if ($queue == "") {
        $queue = 1;
    }
	$estimation_date = $_POST['estimation_date'];
    $cutdate = explode("-", $estimation_date);
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
    $estimation_date = new DateTime("{$estimation_date}");
    $estimation_date = $estimation_date->format('Y-m-d');
    
    $valid = 1;
    $check_sql = "select * from book
                    where book_id = {$book_id};";
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
    
    $create_sql = "insert into book_reservation
                    values ({$user_id},{$book_id},{$queue},'{$estimation_date}');";
    $result = $conn->query($create_sql);
    $check_sql = "select * from book_reservation
                    where user_id={$user_id} and book_id={$book_id} and queue={$queue} and estimation_date='{$estimation_date}';";
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