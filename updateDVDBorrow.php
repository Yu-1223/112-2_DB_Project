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

$user_id_o = $_POST['user_id_o'];
$dvd_id_o = $_POST['dvd_id_o'];
$staff_id_o = $_POST['staff_id_o'];
$borrow_date_o = $_POST['borrow_date_o'];
$return_ddl_o = $_POST['return_ddl_o'];
$user_id = $_POST['user_id'];
$dvd_id = $_POST['dvd_id'];
$staff_id = $_POST['staff_id'];
$borrow_date = $_POST['borrow_date'];
$return_ddl = $_POST['return_ddl'];

$update_sql = "update dvd_borrow
                set user_id={$user_id}, dvd_id={$dvd_id}, staff_id={$staff_id}, borrow_date='{$borrow_date}', return_ddl='{$return_ddl}'
                where user_id={$user_id_o} and dvd_id={$dvd_id_o} and borrow_date='{$borrow_date_o}' and return_ddl='{$return_ddl_o}';";
$result = $conn->query($update_sql);
$check_sql = "select * from dvd_borrow
                where user_id={$user_id} and dvd_id={$dvd_id} and staff_id={$staff_id} and borrow_date='{$borrow_date}' and return_ddl='{$return_ddl}';";
$result = $conn->query($check_sql);

if ($result->num_rows == 0) {
    echo "<h2 align='center'><font color='#5b554e'>修改失敗!!</font></h2>";
    echo "<li><a href=\"updateDVDBorrow_details.php\"><font color='#5b554e'>回到上一頁</font></a></li>";
} else {
    echo "<h2 align='center'><font color='#5b554e'>修改成功!!</font></h2>";
    echo "<li><a href=\"update.php\"><font color='#5b554e'>回到上一頁</font></a></li>";
}

				
?>
