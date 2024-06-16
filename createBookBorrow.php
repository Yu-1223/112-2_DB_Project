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

if (isset($_POST['user_id']) && isset($_POST['book_id']) && isset($_POST['borrow_date']) && isset($_POST['return_ddl'])) {
	$user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $staff_id = $_POST['staff_id'];
    if ($staff_id == "") {
        $staff_id = 1;
    }
	$borrow_date = $_POST['borrow_date'];
    $cutdate = explode("-", $borrow_date);
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
    $borrow_date = new DateTime("{$borrow_date}");
    $borrow_date = $borrow_date->format('Y-m-d');
	$return_ddl = $_POST['return_ddl'];
    $cutdate = explode("-", $return_ddl);
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
    $return_ddl = new DateTime("{$return_ddl}");
    $return_ddl = $return_ddl->format('Y-m-d');
    
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

    $check_sql = "select avail_qty from book_details natural join book
                    where book_id = {$book_id};";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    } else {
        $row = mysqli_fetch_assoc($result);
        if ($row["avail_qty"] == 0) {
            $message = "新增失敗";
            $location = "create.php?msg=" . urlencode($message);
            header("Location: " . $location);
        }
    }

    if ($borrow_date > $return_ddl) {
        $message = "新增失敗";
        $location = "create.php?msg=" . urlencode($message);
        header("Location: " . $location);
    }

    
    $create_sql = "insert into book_borrow(user_id,book_id,staff_id,borrow_date,return_ddl,status)
                    values ({$user_id},{$book_id},{$staff_id},'{$borrow_date}','{$return_ddl}',0);";
    $result = $conn->query($create_sql);
    $check_sql = "select * from book_borrow
                    where user_id={$user_id} and book_id={$book_id} and staff_id={$staff_id} and borrow_date='{$borrow_date}' and return_ddl='{$return_ddl}' and status=0;";
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