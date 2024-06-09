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

    <!--<div class="content">
        <h2>Profile</h2>
        <p><br/></p>-->
        <div  class="profile">
            <div class="profile-content">
                <table style='font-family:"Courier New", Courier, monospace; font-size:20px;text-align: left; width:100%' align=\"left\">
                <tr style="height:80px; font-size:30px">
                    <th colspan="3" align="center">Profile</th>
                <tr>
                <?php
                    session_start();
                    $id = $_SESSION["ID"];
                    //echo "id={$id}";
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
                        // echo "新增成功!!<br> <a href='main.php'>返回主頁</a>";
                        // 重定向用戶到下一頁
                        $row = mysqli_fetch_assoc($result);
                        //echo $row["user_id"];
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
            </div>
            <tr style="height:80px"><th colspan="3" align="center">
                <form action="info_modify.php" method="get">
                    <button style="height:50px;width:100px;font-size:18px;background-color: #5f3f1c;color: #ffffff;border-color: #5f3f1c;" type="submit" onclick="solve()">修改</button>
                </form>
            </th><tr>
        </div>
    <!--</div>-->
</body>
</html>
