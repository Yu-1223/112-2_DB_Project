<!-- select available events from activity table -->
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

    // Get current date
    $currentDate = date('Y-m-d');
    // echo "current date $currentDate<br>";
    // echo "Activity Name: $activityName<br>";
    // echo "Activity Date: $activityDate<br>";
    // echo "User ID: $userID<br>";

    // Query to retrieve available events with dates greater than today
    $sql = "SELECT activity_name, activity_date, room_id FROM activity WHERE activity_date > '$currentDate'";
    // $sql = "SELECT activity_name, activity_date, room_id FROM activity";
    $result = $conn->query($sql);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }

    if ($result->num_rows > 0) {
        echo '<tr style="height:80px; font-size:30px">';
        echo '<th colspan="3" align="center">Available Events</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>活動名稱</th>';
        echo '<th>活動日期</th>';
        echo '<th>活動場地</th>';
        echo '</tr>';               

        // Loop through the results and append each event to the table row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['activity_name'] . '</td>';
            echo '<td>' . $row['activity_date'] . '</td>';
            echo '<td>' . $row['room_id'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo "No available events.";
    }

    $conn->close();
?>
