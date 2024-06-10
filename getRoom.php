<?php
// ******** update your personal settings ******** 
$servername = "140.122.184.129:3310";
$username = "team4";
$password = "4pI@3uqfCfzW09Te";
$dbname = "team4";

// Connecting to and selecting a MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit();
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['activity_date'])) {
    $activityDate = $_POST['activity_date'];

    // Fetch available rooms
    $sql = "SELECT room.room_id, room.capacity 
            FROM room 
            WHERE room.room_id NOT IN (
                SELECT activity.room_id 
                FROM activity 
                WHERE activity.activity_date = ?
            )";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }
    $stmt->bind_param("s", $activityDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $rooms = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }

    // Return rooms as JSON
    echo json_encode($rooms);
} else {
    echo json_encode([]);
}

$conn->close();
?>
