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

if (isset($_POST['first']) && isset($_POST['password']) && isset($_POST['email'])) {
	$username = $_POST['first'];
	$password = hash('sha256', $_POST['password']);
	$email = $_POST['email'];

	$check_sql = "select max(user_id) as max
					from user;";
	$result = $conn->query($check_sql);
	if ($result->num_rows == 0) {
		echo "<h2 align='center'><font color='#a66d2f'>註冊失敗!!</font><br/></h2>";
	} else {
		$row = mysqli_fetch_assoc($result);
		$user_id = $row["max"] + 1;
		$register_sql = "insert into user
							values ({$user_id},NULL,'{$username}','{$password}','{$email}',NULL,NULL);";
		$result = $conn->query($register_sql);
		$check_sql = "select * from user
						where user_id={$user_id} and username='{$username}' and password='{$password}' and email='{$email}';";
		$result = $conn->query($check_sql);
		if ($result->num_rows > 0) {
			//header("Location: login.html");
			$message = "註冊成功";
			$location = "login.html?msg=" . urlencode($message);
			header("Location: " . $location);
			exit;
		} else {
			//echo "<h2 align='center'><font color='#a66d2f'>註冊失敗!!</font><br/></h2>";
			$message = "註冊失敗";
			$location = "register.html?msg=" . urlencode($message);
			header("Location: " . $location);
		}
	}
}else{
	//echo "<h2 align='center'><font color='#a66d2f'>資料不完全</font><br/></h2>";
	$message = "註冊失敗";
	$location = "register.html?msg=" . urlencode($message);
	header("Location: " . $location);
}
				
?>

