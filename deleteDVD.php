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

$dvd_id = $_GET['dvd_id'];
$title = $_GET['title'];
$release_date = $_GET['release_date'];
$release_date = new DateTime("{$release_date}");
$release_date = $release_date->format('Y-m-d');
$publish_company = $_GET['publish_company'];

$update_sql = "delete from dvd
                where dvd_id={$dvd_id};";
$result = $conn->query($update_sql);
$check_sql = "select * from dvd
                where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}' and dvd_id={$dvd_id};";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    $message = "刪除失敗";
	$location = "delete.php?msg=" . urlencode($message);
	header("Location: " . $location);
} else {
    $message = "刪除成功";
	$location = "delete.php?msg=" . urlencode($message);
	header("Location: " . $location);
}

				
?>
