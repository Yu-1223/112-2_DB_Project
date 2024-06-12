<!-- insert booking into activity table -->
<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit;
}

$userID = $_SESSION['ID'];

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

if (isset($_POST['room_id']) && isset($_POST['activity_name']) && isset($_POST['activity_date'])) {
    $roomID = $_POST['room_id'];
    $activityName = $_POST['activity_name'];
    $activityDate = $_POST['activity_date'];

    // Debug: Print received data
    // echo "Room ID: $roomID<br>";
    // echo "Activity Name: $activityName<br>";
    // echo "Activity Date: $activityDate<br>";
    // echo "User ID: $userID<br>";
        
    $insert_sql = "INSERT INTO activity (user_id, room_id, activity_name, activity_date) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($insert_sql);
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("iiss", $userID, $roomID, $activityName, $activityDate);

    if ($stmt->execute() === TRUE) {
        echo "<h2 align='center'><font color='antiquewith'>報名成功!!</font></h2>";
        echo "<br> <a href='index.php'>返回主頁</a>";
        // Redirect the user to the main page
        exit;
    } else {
        echo "<h2 align='center'><font color='antiquewith'>新增失敗!!</font></h2>";
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    
} else {
    echo "資料不完全";
    if (!isset($_POST['room_id'])) echo "Missing room_id<br>";
    if (!isset($_POST['activity_name'])) echo "Missing activity_name<br>";
    if (!isset($_POST['activity_date'])) echo "Missing activity_date<br>";
}

$conn->close();
?>
