<?php
include 'session.php';
session_start();
// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    header("Location: login.html");
    exit();
}
?>

<!-- main page of room booking -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="pop.css">

    <script>
        //get available room for the selected date
        document.addEventListener("DOMContentLoaded", function() {
            const dateInput = document.querySelector('input[name="activity_date"]');
            dateInput.addEventListener('change', function() {
                const activityDate = dateInput.value;

                fetch('getRoom.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `activity_date=${activityDate}`
                })
                .then(response => response.json())
                .then(data => {
                    const roomSelect = document.getElementById('room_id');
                    roomSelect.innerHTML = '<option value="">Select a room</option>'; // Clear previous options
                    data.forEach(room => {
                        const option = document.createElement('option');
                        option.value = room.room_id;
                        option.text = `${room.room_id} (Capacity: ${room.capacity})`;
                        roomSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching room data:', error));
            });
        });

        // Toggle visibility of available events when 活動詳情 button is clicked
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('show').addEventListener('change', function() {
                var availableEvents = document.getElementById('available-events');
                if (this.checked) {
                    availableEvents.style.display = 'none';
                } else {
                    availableEvents.style.display = 'block';
                }
            });

            // Book event button click event listener
            document.getElementById('act-btn').addEventListener('click', function() {
                // Hide the available events div
                document.getElementById('available-events').style.display = 'none';
                // Uncheck the show checkbox
                document.getElementById('show').checked = false;
            });
        });
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-title">
            <img src="lion.png" alt="Icon" class="navbar-icon">獅大圖書館
        </div>
        <ul class="nav-list">
            <li><a href="index.php">首頁</a></li>
            <li><a href="search.php">館藏搜尋</a></li>
            <li><a href="activity.php">活動報名</a></li>
            <li><a href="profile.php">個人資料</a></li>
        </ul>
    </nav>

    <div class="pop-out">
        <input type="checkbox" id="show">
        <label for="show" class="show-btn">活動詳情</label>
        <div class="container">
            <label for="show" class="close-btn" title="close">X</label>
            <div class="text-title">
                活動內容
            </div>
            <div class="text-container">
                <form action="bookActivity.php" method="post">
                    <div class="text">
                        活動名稱: <input type="text" name="activity_name" required>
                    </div>
                    <div class="text">
                        活動日期: <input type="date" name="activity_date" required>
                    </div>
                    <div class="text">
                        活動地點: 
                        <select name="room_id" id="room_id" required>
                            <option value="">Select a room</option>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <button class="act-btn" id="act-btn">
                        報名
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="available-events" style="width: 100%; height: auto; padding-top: 80px;">
        <div class="profile" style="width: 1000px; opacity: 0.8;">
            <div class="profile-content">
                <table style='font-family:"Courier New", Courier, monospace; font-size:20px;text-align: left; width:100%'>
                    <!-- <tr style="height:80px; font-size:30px">
                        <th colspan="3" align="center">Available Events</th>
                    </tr> -->
                    <?php
                        include 'getActivity.php';
                        foreach ($events as $event) {
                            echo '<tr>';
                            echo '<td>' . $event['activity_name'] . '</td>';
                            echo '<td>' . $event['activity_date'] . '</td>';
                            echo '<td>' . $event['room_id'] . '</td>';
                            echo '</tr>';
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
