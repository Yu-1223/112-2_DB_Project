<?php
session_start();
$id = $_SESSION["ID"];
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
    echo "<h2 align='center'><font color='#a66d2f'>修改失敗!!</font><br/></h2>";
    echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
}
				
?>