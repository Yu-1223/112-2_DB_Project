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

if (isset($_POST['user_id']) && isset($_POST['dvd_id']) && isset($_POST['borrow_date']) && isset($_POST['return_ddl'])) {
	$user_id = $_POST['user_id'];
    $dvd_id = $_POST['dvd_id'];
    $staff_id = $_POST['staff_id'];
    if ($staff_id == "") {
        $staff_id = 1;
    }
	$borrow_date = $_POST['borrow_date'];
	$return_ddl = $_POST['return_ddl'];
    
    $valid = 1;
    $check_sql = "select * from dvd
                    where dvd_id = {$dvd_id};";
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
        $check_sql = "select avail_qty from dvd_details natural join dvd
                        where dvd_id = {$dvd_id};";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
            echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
            $valid = 0;
            //echo "insert book_details<br/>";
        } else {
            $row = mysqli_fetch_assoc($result);
            if ($row["avail_qty"] == 0) {
                echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
                echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
                $valid = 0;
            }
        }
    }
    if ($valid == 1) {
        if ($borrow_date > $return_ddl) {
            echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
            echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
            $valid = 0;
            //echo "insert book_details<br/>";
        }
    }
    
    if ($valid == 1) {
	    $create_sql = "insert into dvd_borrow
                        values ({$user_id},{$dvd_id},{$staff_id},'{$borrow_date}','{$return_ddl}','');";
        $result = $conn->query($create_sql);
        $check_sql = "select * from dvd_borrow
                        where user_id={$user_id} and dvd_id={$dvd_id} and staff_id={$staff_id} and borrow_date='{$borrow_date}' and return_ddl='{$return_ddl}' and status='';";
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