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

$user_id = $_GET['user_id'];
$book_id = $_GET['book_id'];
$estimation_date = $_GET['estimation_date'];

$update_sql = "delete from book_reservation
                where user_id={$user_id} and book_id={$book_id} and estimation_date='{$estimation_date}';";
$result = $conn->query($update_sql);
$check_sql = "select * from book_reservation
                where user_id={$user_id} and book_id={$book_id} and estimation_date='{$estimation_date}';";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    echo "<h2 align='center'><font color='#5b554e'>刪除失敗!!</font></h2>";
} else {
    echo "<h2 align='center'><font color='#5b554e'>刪除成功!!</font></h2>";
}
echo "<li><a href=\"delete.php\"><font color='#5b554e'>回到上一頁</font></a></li>";

				
?>
