<?php
session_start();
$id = $_SESSION["ID"];
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


$full_name = $_POST['full_name'];
$username = $_POST['username'];
if ($_POST['password'] != "********") {
    $password = hash('sha256', $_POST['password']);
} else {
    $password = "********";
}
$email = $_POST['email'];
$phone_num = $_POST['phone_num'];
$birthday = $_POST['birthday'];
$cutbirth = explode("-", $birthday);
if (intval($cutbirth[0])<1000 or intval($cutbirth[0])>2024 or intval($cutbirth[1])<1 or intval($cutbirth[1])>12 or intval($cutbirth[2])<1) {
    $message = "修改失敗";
    $location = "profile_modify.php?msg=" . urlencode($message);
    header("Location: " . $location);
} else if (intval($cutbirth[1])>7 and intval($cutbirth[1])%2==0 and intval($cutbirth[2])>31) {
    $message = "修改失敗";
    $location = "profile_modify.php?msg=" . urlencode($message);
    header("Location: " . $location);
} else if (intval($cutbirth[1])>7 and intval($cutbirth[1])%2!=0 and intval($cutbirth[2])>30) {
    $message = "修改失敗";
    $location = "profile_modify.php?msg=" . urlencode($message);
    header("Location: " . $location);
} else if (intval($cutbirth[1])%2!=0 and intval($cutbirth[2])>31) {
    $message = "修改失敗";
    $location = "profile_modify.php?msg=" . urlencode($message);
    header("Location: " . $location);
} else if (intval($cutbirth[1])==2 and intval($cutbirth[2])>29 and (intval($cutbirth[0])%400==0 or (intval($cutbirth[0])%4==0 and intval($cutbirth[0])%100!=0))) {
    $message = "修改失敗";
    $location = "profile_modify.php?msg=" . urlencode($message);
    header("Location: " . $location);
} else if (intval($cutbirth[2])>28) {
    $message = "修改失敗";
    $location = "profile_modify.php?msg=" . urlencode($message);
    header("Location: " . $location);
}
$birthday = str_replace("-", "", $birthday);

$info_sql = "update user
                set full_name='{$full_name}', username='{$username}', ";
if ($password != "********") {
    $info_sql = $info_sql . "password='{$password}', ";
}
$info_sql = $info_sql . "email='{$email}', phone_num='{$phone_num}', birthday='{$birthday}'
                            where user_id = {$id};";
$result = $conn->query($info_sql);
$info_sql = "select * from user
                where full_name='{$full_name}' and username='{$username}' and email='{$email}' and phone_num='{$phone_num}' and birthday='{$birthday}';";
$result = $conn->query($info_sql);

if ($result->num_rows > 0) {
    header("Location: profile.php");
    exit;
} else {
    $message = "修改失敗";
    $location = "profile_modify.php?msg=" . urlencode($message);
    header("Location: " . $location);
}
				
?>