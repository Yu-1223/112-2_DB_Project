<?php

// ******** update your personal settings ******** 
/*$servername = "140.122.184.129:3310";
$username = "team4";
$password = "4pI@3uqfCfzW09Te";
$dbname = "team4";*/
$servername = "localhost";
$username = "root";
$password = "anny920504";
$dbname = "test";

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
    $staff_id = $_POST['staff_id'];
    if ($staff_id == "") {
        $staff_id = 2;
    }
    $activity_name = $_POST['activity_name'];
	$activity_date = $_POST['activity_date'];
    
    $valid = 1;
    $check_sql = "select * from room
                    where room_id = {$room_id};";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
        echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
        $valid = 0;
        //echo "insert book_details<br/>";
    }
    if ($valid == 1) {
        $check_sql = "select * from user
                        where user_id = {$user_id};";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
            echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
            $valid = 0;
            //echo "insert book_details<br/>";
        }
    }
    
    if ($valid == 1) {
	    $create_sql = "insert into activity
                        values ({$user_id},{$room_id},{$staff_id},'{$activity_name}','{$activity_date}');";
        $result = $conn->query($create_sql);
        $check_sql = "select * from activity
                        where user_id={$user_id} and room_id={$room_id} and staff_id={$staff_id} and activity_name='{$activity_name}' and activity_date='{$activity_date}';";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
            echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
            $valid = 0;
            //echo "insert book_id<br/>";
        }
    }

    if ($valid == 1)
    {
        echo "<h2 align='center'><font color='#5b554e'>新增成功!!</font><br/></h2>";
        echo "<li><a href=\"create.html\"><font color='#5b554e'>回到上一頁</font></a></li>";
    }

}else{
	echo "<h2 align='center'><font color='#5b554e'>資料不完全</font><br/></h2>";
}
				
?>