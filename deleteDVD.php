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

$dvd_id = $_GET['dvd_id'];
$title = $_GET['title'];
$release_date = $_GET['release_date'];
$publish_company = $_GET['publish_company'];

$update_sql = "delete from dvd
                where dvd_id={$dvd_id};";
$result = $conn->query($update_sql);
echo $update_sql . "<br/>";
$check_sql = "select * from dvd
                where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}' and dvd_id={$dvd_id};";
$result = $conn->query($check_sql);
echo $check_sql . "<br/>";

if ($result->num_rows > 0) {
    echo "<h2 align='center'><font color='#5b554e'>刪除失敗!!</font></h2>";
} else {
    echo "<h2 align='center'><font color='#5b554e'>刪除成功!!</font></h2>";
}

echo "<li><a href=\"delete.php\"><font color='#5b554e'>回到上一頁</font></a></li>";

				
?>
