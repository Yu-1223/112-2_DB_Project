<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link rel="stylesheet" href="modify.css">
    <style>
        .form-div {
            display: none;
        }
    </style>
</head>
<body>
    <div style="display: flex; align-items: center; justify-content: center; margin: 0;">
        <h2 style="color:#ffffff">更新圖書資料</h2>
    </div>
    <form action="updateAct.php" method="post">	
        <table width="500" border="1" bgcolor="#cccccc" align="center">
            <?php
                $user_id = $_GET['user_id'];
                $room_id = $_GET['room_id'];
                $activity_date = $_GET['activity_date'];

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

                $search_sql = "select * 
                                from activity
                                where user_id={$user_id} and room_id={$room_id} and activity_date='{$activity_date}';";
                $result = $conn->query($search_sql);

                if ($result->num_rows > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<tr>
                            <th>使用者ID</th>
                            <td bgcolor=\"#5b554e\">
                                <input type=\"text\" name=\"user_id\" value=\"{$row["user_id"]}\" required/>
                                <input type=\"hidden\" name=\"user_id_o\" value=\"{$row["user_id"]}\"/>
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>場地 ID</th>
                            <td bgcolor=\"#5b554e\">
                                <input type=\"text\" name=\"room_id\" value=\"{$row["room_id"]}\" required/>
                                <input type=\"hidden\" name=\"room_id_o\" value=\"{$row["room_id"]}\"/>
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>負責館員ID</th>
                            <td bgcolor=\"#5b554e\">
                                <input type=\"text\" name=\"staff_id\" value=\"{$row["staff_id"]}\" required/>
                                <input type=\"hidden\" name=\"staff_id_o\" value=\"{$row["staff_id"]}\"/>
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>活動名稱</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"activity_name\" value=\"{$row["activity_name"]}\">
                                <input  type=\"hidden\" name=\"activity_name_o\" value=\"{$row["activity_name"]}\">
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>活動日期</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"activity_date\" placeholder=\"YYYY-MM-DD\" value=\"{$row["activity_date"]}\" required>
                                <input  type=\"hidden\" name=\"activity_date_o\" value=\"{$row["activity_date"]}\">
                            </td>
                        </tr>";
                    
                    echo "<tr>
                            <th colspan=\"2\"><input type=\"submit\" value=\"更新\"/></th>  
                        </tr>";
                } else {
                    echo "<h2 align='center' style=\"color:#ffffff\">載入失敗!!</h2>";
                    echo "<li><a href=\"update.php\"><font color='#ffffff'>回到上一頁</font></a></li>";
                }
            ?>
        </table>
    </form>
</body>
</html>

