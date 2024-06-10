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
    <form action="updateBook.php" method="post">	
        <table width="500" border="1" bgcolor="#cccccc" align="center">
            <?php
                $ISBN = $_GET["ISBN"];
                $book_id = $_GET["book_id"];
                $genre = $_GET["genre"];

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
                                from book_details natural join book natural join book_genre
                                where book_id={$book_id} and ISBN='{$ISBN}' and genre='{$genre}';";
                $result = $conn->query($search_sql);

                if ($result->num_rows > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<tr>
                            <th>ID</th>
                            <td bgcolor=\"#5b554e\">
                                <input type=\"text\" name=\"book_id\" value=\"{$row["book_id"]}\" readonly/>
                                <input type=\"hidden\" name=\"book_id_o\" value=\"{$row["book_id"]}\"/>
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>ISBN</th>
                            <td bgcolor=\"#5b554e\">
                                <input type=\"text\" name=\"ISBN\" value=\"{$row["ISBN"]}\" required/>
                                <input type=\"hidden\" name=\"ISBN_o\" value=\"{$row["ISBN"]}\"/>
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>書名</th>
                            <td bgcolor=\"#5b554e\">
                                <input type=\"text\" name=\"title\" value=\"{$row["title"]}\"/>
                                <input type=\"hidden\" name=\"title_o\" value=\"{$row["title"]}\"/>
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>作者</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"author\" value=\"{$row["author"]}\">
                                <input  type=\"hidden\" name=\"author_o\" value=\"{$row["author"]}\">
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>出版社</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"publisher\" value=\"{$row["publisher"]}\">
                                <input  type=\"hidden\" name=\"publisher_o\" value=\"{$row["publisher"]}\">
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>出版日期</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"publish_date\" placeholder=\"YYYY-MM-DD\" value=\"{$row["publish_date"]}\">
                                <input  type=\"hidden\" name=\"publish_date_o\" value=\"{$row["publish_date"]}\">
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
                            <th>版本</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"version\" value=\"{$row["version"]}\">
                                <input  type=\"hidden\" name=\"version_o\" value=\"{$row["version"]}\">
                            </td>
                        </tr>";
                    echo "<tr>
                            <th>頁數</th>
                            <td bgcolor=\"#5b554e\">
                                <input  type=\"text\" name=\"page_num\" value=\"{$row["page_num"]}\">
                                <input  type=\"hidden\" name=\"page_num_o\" value=\"{$row["page_num"]}\">
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

