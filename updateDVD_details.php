<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update DVD</title>
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
    <form action="updateDVD.php" method="post">	
        <table width="500" border="1" bgcolor="#cccccc" align="center">
            <?php
                $title = $_GET["title"];
                $release_date = $_GET["release_date"];
                $publish_company = $_GET["publish_company"];
                $dvd_id = $_GET["dvd_id"];
                $genre = $_GET["genre"];

                // ******** update your personal settings ******** 
                /*$servername = "140.122.184.129:3310";
                $username = "team4";
                $password = "4pI@3uqfCfzW09Te";
                $dbname = "team4";*/
                $servername = "localhost";
                $username = "root";
                $password = "anny920504";
                $dbname = "test";
        
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
                                from dvd_details natural join dvd natural join dvd_genre
                                where dvd_id={$dvd_id} and title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}' and genre='{$genre}';";
                $result = $conn->query($search_sql);

                if ($result->num_rows > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<tr>
                            <th>ID</th>
                            <td bgcolor=\"#5b554e\">
                                <input type=\"text\" name=\"dvd_id\" value=\"{$row["dvd_id"]}\" readonly/>
                                <input type=\"hidden\" name=\"dvd_id_o\" value=\"{$row["dvd_id"]}\"/>
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>名稱</th>
                            <td bgcolor=\"#5b554e\">
                                <input type=\"text\" name=\"title\" value=\"{$row["title"]}\" required/>
                                <input type=\"hidden\" name=\"title_o\" value=\"{$row["title"]}\"/>
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>演員</th>
                            <td bgcolor=\"#5b554e\">
                                <input type=\"text\" name=\"actor\" value=\"{$row["actor"]}\"/>
                                <input type=\"hidden\" name=\"actor_o\" value=\"{$row["actor"]}\"/>
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>導演</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"director\" value=\"{$row["director"]}\">
                                <input  type=\"hidden\" name=\"director_o\" value=\"{$row["director"]}\">
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>時長</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"duration\" value=\"{$row["duration"]}\">
                                <input  type=\"hidden\" name=\"duration_o\" value=\"{$row["duration"]}\">
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>上映日期</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"release_date\" placeholder=\"YYYY-MM-DD\" value=\"{$row["release_date"]}\">
                                <input  type=\"hidden\" name=\"release_date_o\" value=\"{$row["release_date"]}\">
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>類型</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"genre\" placeholder=\"Leave blank if you want to delete this genre\" value=\"{$row["genre"]}\">
                                <input  type=\"hidden\" name=\"genre_o\" value=\"{$row["genre"]}\">
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>發行公司</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"publish_company\" value=\"{$row["publish_company"]}\">
                                <input  type=\"hidden\" name=\"publish_company_o\" value=\"{$row["publish_company"]}\">
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>語言</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"language\" value=\"{$row["language"]}\">
                                <input  type=\"hidden\" name=\"language_o\" value=\"{$row["language"]}\">
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

