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

if (isset($_POST['first']) && isset($_POST['password']) && isset($_POST['option'])) {
	$first = $_POST['first'];
	$password = hash('sha256', $_POST['password']);
	$option = $_POST['option'];

	if ($option == "staff") {
		$login_sql = "select * from staff
						where username = '{$first}' and password = '{$password}';";
	} else {
		$login_sql = "select * from user
						where username = '{$first}' and password = '{$password}';";
	}
	$result = $conn->query($login_sql);
	
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		if ($option == "staff") {
			session_start();
			$_SESSION["ID"] = $row["staff_id"];
			header("Location: modify.php");
		} else {
			session_start();
			$_SESSION["ID"] = $row["user_id"];
			header("Location: index.php");
		}
		exit;
	} else {
		$message = "登入失敗";
		$location = "login.html?msg=" . urlencode($message);
		header("Location: " . $location);
	}

}else{
	$message = "登入失敗";
	$location = "login.html?msg=" . urlencode($message);
	header("Location: " . $location);
}
				
?>