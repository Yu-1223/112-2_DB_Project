<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container{
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            padding-top: 100px;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            gap: 30px;
        }
        .profile{
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-title">
            <img src="lion.png" alt="Icon" class="navbar-icon">獅大圖書館</div>
        <ul class="nav-list">
            <li><a href="index.php">首頁</a></li>
            <li><a href="search.php">館藏搜尋</a></li>
            <li><a href="activity.html">活動報名</a></li>
            <li><a href="profile.php">個人資料</a></li>
        </ul>
    </nav>

    <div class="container">
        <div  class="profile" style="height: auto; padding-bottom: 100px;">
            <div class="profile-content">
                <table style='font-family:"Courier New", Courier, monospace; font-size:20px;text-align: left; width:100%' align=\"left\">
                    <tr style="height:80px; font-size:30px">
                        <th colspan="3" align="center">Profile</th>
                    <tr>
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

                        $profile_sql = "select * from user
                                            where user_id = {$id};";
                        $result = $conn->query($profile_sql);
                        
                        if ($result->num_rows > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<tr style=\"height:45px\"><th>姓名: </th><th colspan=\"2\">{$row["full_name"]}</th></tr>";
                            echo "<tr style=\"height:45px\"><th>帳號: </th><th colspan=\"2\">{$row["username"]}</th></tr>";
                            echo "<tr style=\"height:45px\"><th>密碼: </th><th colspan=\"2\">********</th></tr>";
                            echo "<tr style=\"height:45px\"><th>Email: </th><th colspan=\"2\">{$row["email"]}</th></tr>";
                            echo "<tr style=\"height:45px\"><th>手機: </th><th colspan=\"2\">{$row["phone_num"]}</th></tr>";
                            echo "<tr style=\"height:45px\"><th>生日: </th><th colspan=\"2\">{$row["birthday"]}</th></tr>";
                        } else {
                            echo "<h2 align='center'>載入失敗!!</h2>";
                        }
                    ?>
                    <div style="height:80px"><th colspan="3" align="center">
                        <form action="profile_modify.php" method="get">
                            <button style="height:50px;width:100px;font-size:18px;background-color: #5f3f1c;color: #ffffff;border-color: #5f3f1c;" type="submit" onclick="solve()">修改</button>
                        </form>
                        </th><tr>
                    </div>
                </table>
            </div>
        </div>
        <div  class="profile" style="padding-top: 100px;">
            <div class="profile-content">
                <table style='font-family:"Courier New", Courier, monospace; font-size:20px;text-align: left; width:100%' align=\"left\">
                    <tr style="height:80px; font-size:30px">
                        <th colspan="3" align="center">Registered Activity</th>
                    <tr>
                    <?php
                        $activitySearch_sql = "SELECT activity_name, activity_date, room_id from activity where user_id = {$id};";
                        $activityResult = $conn->query($activitySearch_sql);
                        if($activityResult->num_rows > 0)
                        {
                            echo '<tr>';
                            echo '<th>活動名稱</th>';
                            echo '<th>活動日期</th>';
                            echo '<th>活動場地</th>';
                            echo '</tr>'; 
                            
                            while ($row = $activityResult->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['activity_name'] . '</td>';
                                echo '<td>' . $row['activity_date'] . '</td>';
                                echo '<td>' . $row['room_id'] . '</td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo "No available events.";
                        }
                    ?>
                </table>
            </div>
        </div>
        <div  class="profile" style="padding-top: 100px; width: 900px; height: auto; padding-bottom: 100px;">
            <div class="profile-content">
                <table style='font-family:"Courier New", Courier, monospace; font-size:20px;text-align: left; width:100%' align=\"left\">
                    <tr style="height:80px; font-size:30px">
                        <th colspan="3" align="center">Book Borrow History</th>
                    <tr>
                    <?php
                        $bookSearch_sql = "SELECT book_details.title, book_borrow.borrow_date, book_borrow.return_ddl, book_borrow.status from book_borrow NATURAL JOIN book NATURAL JOIN book_details where user_id = {$id};";
                        $bookResult = $conn->query($bookSearch_sql);
                        if($bookResult->num_rows > 0)
                        {
                            echo '<tr>';
                            echo '<th>書名</th>';
                            echo '<th>借書日期</th>';
                            echo '<th>還書日期</th>';
                            echo '<th>借書狀態</th>';
                            echo '</tr>'; 
                            
                            while ($row = $bookResult->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['title'] . '</td>';
                                echo '<td>' . $row['borrow_date'] . '</td>';
                                echo '<td>' . $row['return_ddl'] . '</td>';
                                echo '<td>' . ($row['status'] == 1 ? 'returned' : 'not returned') . '</td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo "No available record.";
                        }
                    ?>
                </table>
                <table style='font-family:"Courier New", Courier, monospace; font-size:20px;text-align: left; width:100%' align=\"left\">
                    <tr style="height:80px; font-size:30px">
                        <th colspan="3" align="center">DVD Borrow History</th>
                    <tr>
                    <?php
                        $dvdSearch_sql = "SELECT dvd_details.title, dvd_borrow.borrow_date, dvd_borrow.return_ddl, dvd_borrow.status from dvd_borrow NATURAL JOIN dvd NATURAL JOIN dvd_details where user_id = {$id};";
                        $dvdResult = $conn->query($dvdSearch_sql);
                        if($dvdResult->num_rows > 0)
                        {
                            echo '<tr>';
                            echo '<th>片名</th>';
                            echo '<th>借片日期</th>';
                            echo '<th>還片日期</th>';
                            echo '<th>借片狀態</th>';
                            echo '</tr>'; 
                            
                            while ($row = $dvdResult->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['title'] . '</td>';
                                echo '<td>' . $row['borrow_date'] . '</td>';
                                echo '<td>' . $row['return_ddl'] . '</td>';
                                echo '<td>' . ($row['status'] == 1 ? 'returned' : 'not returned') . '</td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo "No available record.";
                        }
                    ?>
                </table>
            </div>
        </div>
        
        <div  class="profile" style="padding-top: 100px; width: 900px; height: auto; padding-bottom: 100px;">
            <div class="profile-content">
                <table style='font-family:"Courier New", Courier, monospace; font-size:20px;text-align: left; width:100%' align=\"left\">
                    <tr style="height:80px; font-size:30px">
                        <th colspan="3" align="center">Book Reservation History</th>
                    <tr>
                    <?php
                        $bookSearch_sql = "SELECT book_details.title, book_reservation.estimation_date from book_reservation NATURAL JOIN book NATURAL JOIN book_details where user_id = {$id};";
                        $bookResult = $conn->query($bookSearch_sql);
                        if($bookResult->num_rows > 0)
                        {
                            echo '<tr>';
                            echo '<th>書名</th>';
                            echo '<th>預計取書日期</th>';
                            echo '</tr>'; 
                            
                            while ($row = $bookResult->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['title'] . '</td>';
                                echo '<td>' . $row['estimation_date'] . '</td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo "No available record.";
                        }
                    ?>
                </table>
                <table style='font-family:"Courier New", Courier, monospace; font-size:20px;text-align: left; width:100%' align=\"left\">
                    <tr style="height:80px; font-size:30px">
                        <th colspan="3" align="center">DVD Borrow History</th>
                    <tr>
                    <?php
                        $dvdSearch_sql = "SELECT dvd_details.title, dvd_reservation.estimation_date from dvd_reservation NATURAL JOIN dvd NATURAL JOIN dvd_details where user_id = {$id};";
                        $dvdResult = $conn->query($dvdSearch_sql);
                        if($dvdResult->num_rows > 0)
                        {
                            echo '<tr>';
                            echo '<th>片名</th>';
                            echo '<th>預計取書日期</th>';
                            echo '</tr>'; 
                            
                            while ($row = $dvdResult->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['title'] . '</td>';
                                echo '<td>' . $row['borrow_date'] . '</td>';
                                echo '<td>' . $row['return_ddl'] . '</td>';
                                echo '<td>' . ($row['status'] == 1 ? 'returned' : 'not returned') . '</td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo "No available record.";
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
