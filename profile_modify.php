<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
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

    <div  class="profile">
        <form action="send_new_info.php" method="post">
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
                                        where user_id = '{$id}';";
                    $result = $conn->query($profile_sql);
                    
                    if ($result->num_rows > 0) {
                        $row = mysqli_fetch_assoc($result);
                        echo "<tr style=\"height:45px\">
                                    <th>姓名: </th>
                                    <th colspan=\"2\">
                                    <input type=\"full_name\" id=\"full_name\" name=\"full_name\" value=\"{$row["full_name"]}\" style=\"height:20px;width:300px;background:#cccccce0\">
                                    </th>
                                </tr>";
                        echo "<tr style=\"height:45px\">
                                    <th>帳號: </th>
                                    <th colspan=\"2\">
                                    <input type=\"username\" id=\"username\" name=\"username\" value=\"{$row["username"]}\" style=\"height:20px;width:300px;background:#cccccce0\" required>
                                    </th>
                                </tr>";
                        echo "<tr style=\"height:45px\">
                                    <th>密碼: </th>
                                    <th colspan=\"2\">
                                    <input type=\"password\" id=\"password\" name=\"password\" value=\"********\" style=\"height:20px;width:300px;background:#cccccce0\" required>
                                    </th>
                                </tr>";
                        echo "<tr style=\"height:45px\">
                                    <th>Email: </th>
                                    <th colspan=\"2\">
                                    <input type=\"email\" id=\"email\" name=\"email\" value=\"{$row["email"]}\" style=\"height:20px;width:300px;background:#cccccce0\">
                                    </th>
                                </tr>";
                        echo "<tr style=\"height:45px\">
                                    <th>手機: </th>
                                    <th colspan=\"2\">
                                    <input type=\"phone_num\" id=\"phone_num\" name=\"phone_num\" value=\"{$row["phone_num"]}\" style=\"height:20px;width:300px;background:#cccccce0\">
                                    </th>
                                </tr>";
                        echo "<tr style=\"height:45px\">
                                    <th>生日: </th>
                                    <th colspan=\"2\">
                                    <input type=\"birthday\" id=\"birthday\" name=\"birthday\" placeholder=\"YYYY-MM-DD\" value=\"{$row["birthday"]}\" style=\"height:20px;width:300px;background:#cccccce0\">
                                    </th>
                                </tr>";
                    } else {
                        echo "<h2 align='center'>載入失敗!!</h2>";
                    }
                ?>
            </div>
            <tr style="height:80px"><th colspan="3" align="center">
                <button style="height:50px;width:100px;font-size:18px;background-color: #5f3f1c;color: #ffffff;border-color: #5f3f1c;" type="submit" onclick="solve()">修改</button>
            </th><tr>
        </form>
    </div>
</body>
</html>
