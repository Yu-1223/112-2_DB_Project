<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="modify.css">
    <style>
        .form-div {
            display: none;
        }
    </style>
    <script>
        function showForm(formId) {
            // Hide all forms
            const forms = document.querySelectorAll('.form-div');
            forms.forEach(form => form.style.display = 'none');

            // Show the selected form
            document.getElementById(formId).style.display = 'block';
        }
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-title">
            <img src="lion.png" alt="Icon" class="navbar-icon">獅大圖書館管理系統</div>
        <ul class="nav-list">
            <li><a href="modify.html">首頁</a></li>
            <li><a href="delete.php">刪除資料</a></li>
            <li><a href="update.php">更新資料</a></li>
            <li><a href="create.html">新增資料</a></li>
        </ul>
    </nav>

    <div class="content" style="margin-top: 100px;">
        <button onclick="showForm('form-1')">刪除圖書資料</button>
        <button onclick="showForm('form-2')">刪除DVD資料</button>
        <button onclick="showForm('form-3')">刪除書籍借閱紀錄</button>
        <button onclick="showForm('form-4')">刪除DVD借閱紀錄</button>
        <button onclick="showForm('form-5')">刪除書籍預約紀錄</button>
        <button onclick="showForm('form-6')">刪除DVD預約紀錄</button>
        <button onclick="showForm('form-7')">刪除活動資料</button>
    </div>

    <div class="data-show">
        <div id="form-1" class="form-div">
            <table style="width:100%" align="center">
            <tr>
                <th>ISBN</th><th>Book ID</th><th>書名</th><th>作者</th>
                <th>出版社</th><th>出版日期</th><th>版本</th>
                <th>頁數</th><th>語言</th>
            </tr>
            <?php
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
                                from book_details natural join book
                                order by ISBN asc, book_id asc;";
                $result = $conn->query($search_sql);
                //echo $search_sql . "<br/>";

                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"deleteBook.php\" method=\"get\">
                                <tr>
                                    <th>
                                        {$row["ISBN"]}
                                        <input type=\"hidden\" id=\"ISBN\" name=\"ISBN\" value=\"{$row["ISBN"]}\">
                                    </th>
                                    <th>
                                        {$row["book_id"]}
                                        <input type=\"hidden\" id=\"book_id\" name=\"book_id\" value=\"{$row["book_id"]}\">
                                    </th>
                                    <th>
                                        {$row["title"]}
                                    </th>
                                    <th>
                                        {$row["author"]}
                                    </th>
                                    <th>
                                        {$row["publisher"]}
                                    </th>
                                    <th>
                                        {$row["publish_date"]}
                                    </th>
                                    <th>
                                        {$row["version"]}
                                    </th>
                                    <th>
                                        {$row["page_num"]}
                                    </th>
                                    <th>
                                        {$row["language"]}
                                    </th>
                                    <th>
                                        <button type=\"submit\" onclick=\"solve()\">
                                            刪除
                                        </button>
                                    </th>
                                </tr>
                            </form>";
                    }
                }
            ?>
            </table>
        </div>

        <div id="form-2" class="form-div">
            <table style="width:100%" align="center">
            <tr>
                <th>DVD ID</th><th>名稱</th><th>演員</th>
                <th>導演</th><th>時長</th><th>上映日期</th>
                <th>發行公司</th><th>語言</th>
            </tr>
            <?php
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
                                from dvd_details natural join dvd
                                order by title asc, dvd_id asc;";
                $result = $conn->query($search_sql);

                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"deleteDVD.php\" method=\"get\">
                                <tr>
                                    <th>
                                        {$row["dvd_id"]}
                                        <input type=\"hidden\" id=\"dvd_id\" name=\"dvd_id\" value=\"{$row["dvd_id"]}\">
                                    </th>
                                    <th>
                                        {$row["title"]}
                                        <input type=\"hidden\" id=\"title\" name=\"title\" value=\"{$row["title"]}\">
                                    </th>
                                    <th>
                                        {$row["actor"]}
                                    </th>
                                    <th>
                                        {$row["director"]}
                                    </th>
                                    <th>
                                        {$row["duration"]}
                                    </th>
                                    <th>
                                        {$row["release_date"]}
                                        <input type=\"hidden\" id=\"release_date\" name=\"release_date\" value=\"{$row["release_date"]}\">
                                    </th>
                                    <th>
                                        {$row["publish_company"]}
                                        <input type=\"hidden\" id=\"publish_company\" name=\"publish_company\" value=\"{$row["publish_company"]}\">
                                    </th>
                                    <th>
                                        {$row["language"]}
                                    </th>
                                    <th>
                                        <button type=\"submit\" onclick=\"solve()\">
                                            刪除
                                        </button>
                                    </th>
                                </tr>
                            </form>";
                    }
                }
            ?>
            </table>
        </div>

        <div id="form-3" class="form-div">
            <table style="width:100%" align="center">
            <tr>
                <th>使用者ID</th><th>書籍ID</th><th>館員ID</th>
                <th>借閱日期</th><th>還書日期</th>
            </tr>
            <?php
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
                                from book_borrow
                                order by book_id asc, user_id asc;";
                $result = $conn->query($search_sql);

                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"deleteBookBorrow.php\" method=\"get\">
                                <tr>
                                    <th>
                                        {$row["user_id"]}
                                        <input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"{$row["user_id"]}\">
                                    </th>
                                    <th>
                                        {$row["book_id"]}
                                        <input type=\"hidden\" id=\"book_id\" name=\"book_id\" value=\"{$row["book_id"]}\">
                                    </th>
                                    <th>
                                        {$row["staff_id"]}
                                    </th>
                                    <th>
                                        {$row["borrow_date"]}
                                        <input type=\"hidden\" id=\"borrow_date\" name=\"borrow_date\" value=\"{$row["borrow_date"]}\">
                                    </th>
                                    <th>
                                        {$row["return_ddl"]}
                                        <input type=\"hidden\" id=\"return_ddl\" name=\"return_ddl\" value=\"{$row["return_ddl"]}\">
                                    </th>
                                    <th>
                                        <button type=\"submit\" onclick=\"solve()\">
                                            刪除
                                        </button>
                                    </th>
                                </tr>
                            </form>";
                    }
                }
            ?>
            </table>
        </div>

        <div id="form-4" class="form-div">
            <table style="width:100%" align="center">
            <tr>
                <th>使用者ID</th><th>DVD ID</th><th>館員ID</th>
                <th>借閱日期</th><th>還書日期</th>
            </tr>
            <?php
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
                                from dvd_borrow
                                order by dvd_id asc, user_id asc;";
                $result = $conn->query($search_sql);

                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"deleteDVDBorrow.php\" method=\"get\">
                                <tr>
                                    <th>
                                        {$row["user_id"]}
                                        <input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"{$row["user_id"]}\">
                                    </th>
                                    <th>
                                        {$row["dvd_id"]}
                                        <input type=\"hidden\" id=\"dvd_id\" name=\"dvd_id\" value=\"{$row["dvd_id"]}\">
                                    </th>
                                    <th>
                                        {$row["staff_id"]}
                                    </th>
                                    <th>
                                        {$row["borrow_date"]}
                                        <input type=\"hidden\" id=\"borrow_date\" name=\"borrow_date\" value=\"{$row["borrow_date"]}\">
                                    </th>
                                    <th>
                                        {$row["return_ddl"]}
                                        <input type=\"hidden\" id=\"return_ddl\" name=\"return_ddl\" value=\"{$row["return_ddl"]}\">
                                    </th>
                                    <th>
                                        <button type=\"submit\" onclick=\"solve()\">
                                            刪除
                                        </button>
                                    </th>
                                </tr>
                            </form>";
                    }
                }
            ?>
            </table>
        </div>

        <div id="form-5" class="form-div">
            <table style="width:100%" align="center">
            <tr>
                <th>使用者ID</th><th>書籍ID</th><th>序號</th><th>取書日期</th>
            </tr>
            <?php
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
                                from book_reservation
                                order by book_id asc, user_id asc;";
                $result = $conn->query($search_sql);

                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"deleteBookRes.php\" method=\"get\">
                                <tr>
                                    <th>
                                        {$row["user_id"]}
                                        <input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"{$row["user_id"]}\">
                                    </th>
                                    <th>
                                        {$row["book_id"]}
                                        <input type=\"hidden\" id=\"book_id\" name=\"book_id\" value=\"{$row["book_id"]}\">
                                    </th>
                                    <th>
                                        {$row["queue"]}
                                    </th>
                                    <th>
                                        {$row["estimation_date"]}
                                        <input type=\"hidden\" id=\"estimation_date\" name=\"estimation_date\" value=\"{$row["estimation_date"]}\">
                                    </th>
                                    <th>
                                        <button type=\"submit\" onclick=\"solve()\">
                                            刪除
                                        </button>
                                    </th>
                                </tr>
                            </form>";
                    }
                }
            ?>
            </table>
        </div>

        <div id="form-6" class="form-div">
            <table style="width:100%" align="center">
            <tr>
                <th>使用者ID</th><th>DVD ID</th><th>序號</th><th>取件日期</th>
            </tr>
            <?php
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
                                from dvd_reservation
                                order by dvd_id asc, user_id asc;";
                $result = $conn->query($search_sql);

                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"deleteDVDRes.php\" method=\"get\">
                                <tr>
                                    <th>
                                        {$row["user_id"]}
                                        <input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"{$row["user_id"]}\">
                                    </th>
                                    <th>
                                        {$row["dvd_id"]}
                                        <input type=\"hidden\" id=\"dvd_id\" name=\"dvd_id\" value=\"{$row["dvd_id"]}\">
                                    </th>
                                    <th>
                                        {$row["queue"]}
                                    </th>
                                    <th>
                                        {$row["estimation_date"]}
                                        <input type=\"hidden\" id=\"estimation_date\" name=\"estimation_date\" value=\"{$row["estimation_date"]}\">
                                    </th>
                                    <th>
                                        <button type=\"submit\" onclick=\"solve()\">
                                            刪除
                                        </button>
                                    </th>
                                </tr>
                            </form>";
                    }
                }
            ?>
            </table>
        </div>

        <div id="form-7" class="form-div" style="margin-bottom: 40px;">
            <table style="width:100%" align="center">
            <tr>
                <th>使用者ID</th><th>場地 ID</th><th>負責館員ID</th><th>活動名稱</th><th>活動日期</th>
            </tr>
            <?php
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
                                from activity
                                order by room_id asc, user_id asc;";
                $result = $conn->query($search_sql);

                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"deleteAct.php\" method=\"get\">
                                <tr>
                                    <th>
                                        {$row["user_id"]}
                                        <input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"{$row["user_id"]}\">
                                    </th>
                                    <th>
                                        {$row["room_id"]}
                                        <input type=\"hidden\" id=\"room_id\" name=\"room_id\" value=\"{$row["room_id"]}\">
                                    </th>
                                    <th>
                                        {$row["staff_id"]}
                                    </th>
                                    <th>
                                        {$row["activity_name"]}
                                    </th>
                                    <th>
                                        {$row["activity_date"]}
                                        <input type=\"hidden\" id=\"activity_date\" name=\"activity_date\" value=\"{$row["activity_date"]}\">
                                    </th>
                                    <th>
                                        <button type=\"submit\" onclick=\"solve()\">
                                            刪除
                                        </button>
                                    </th>
                                </tr>
                            </form>";
                    }
                }
            ?>
            </table>
        </div>
    </div>
</body>
</html>
