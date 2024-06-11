<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="pop.css">
</head>
<body>
    <?php
        include 'session.php';
        session_start();
        // Check if the user is logged in
        if (!isset($_SESSION['ID'])) {
            header("Location: login.html");
            exit();
        }
    ?>
    <nav class="navbar">
        <div class="navbar-title">
            <img src="lion.png" alt="Icon" class="navbar-icon">獅大圖書館</div>
        <ul class="nav-list">
            <?php
                echo "<li><a href=\"index.php\">首頁</a></li>";
                echo "<li><a href=\"search.php\">館藏搜尋</a></li>";
                echo "<li><a href=\"activity.php\">活動報名</a></li>";
                echo "<li><a href=\"profile.php\">個人資料</a></li>";
            ?>
        </ul>
    </nav>

    <div class="search-content">
        <form action="search.php" method="get">
            <div class="search-input">
                <div class="option-container">
                    <select name="search-item" id="search-item" class="search-option" required>
                        <option value="" disabled selected>搜尋選擇</option>
                        <option value="book">書籍</option>
                        <option value="dvd">DVD</option>
                    </select>
                    <select name="search-by" id="search-by" class="search-option" required>
                        <option value="" disabled selected>搜尋方式</option>
                        <!-- Options will be dynamically generated based on the selection in search-item -->
                    </select>
                </div>  
                <div class="search-form">
                    <form class="search-form" id="search-form">
                        <input type="text" placeholder="搜尋館藏" name="search" autocomplete="off">
                        <button type="submit">搜尋</button>
                    </form>
                </div>
            </div>
        </form> 
        <div>
            <p style="line-height: 40px; color:#5f3f1c; font-weight: 700;">
                搜尋方式說明:<br>
                1.本館館藏包含書籍及DVD，請先選擇要搜尋的項目<br>
                2.選擇項目後即可選擇搜尋方式 ex. 書名，IBSN...<br>
                3.在選擇完之後即可輸入要搜尋的資料
            </p>
        </div>
    </div>

    <?php
        session_start();
        $user_id = $_SESSION["ID"];
        date_default_timezone_set('Asia/Taipei');
        echo "<div  class=\"search-result\">";
        // ******** update your personal settings ******** 
        $servername = "140.122.184.129:3310";
        $username = "team4";
        $password = "4pI@3uqfCfzW09Te";
        $dbname = "team4";
        /*$servername = "localhost";
        $username = "root";
        $password = "anny920504";
        $dbname = "test";*/

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

        if (isset($_GET['search-item']) && isset($_GET['search-by']) && isset($_GET['search'])) {
            $item = $_GET['search-item'];
            $method = $_GET['search-by'];
            $search = $_GET['search'];

            if ($method != "genre") {
                $search_sql = "select * from {$item}_details
                                where {$method} like \"%{$search}%\";";
            } else {
                $search_sql = "select * from {$item}_genre natural join {$item}_details
                                where {$method} like '%{$search}%';";
            }
            $result = $conn->query($search_sql);
            
            if ($result->num_rows > 0) {
                echo "<table style=\"width:100%\" align=\"center\">";
                if ($item == "book") {
                    echo "<tr><th>ISBN</th><th>書名</th><th>作者</th>
                            <th>出版社</th><th>出版日期</th><th>版本</th>
                            <th>頁數</th><th>語言</th><th>館藏數量</th><th>可借數量</th>
                            <th></th></tr>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"reservate_book.php\" method=\"get\">
                                <tr style=\"height: 50px\">
                                    <th>
                                        {$row["ISBN"]}
                                        <input type=\"hidden\" id=\"ISBN\" name=\"ISBN\" value=\"{$row["ISBN"]}\">
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
                                        {$row["tot_qty"]}
                                    </th>
                                    <th>
                                        {$row["avail_qty"]}
                                    </th>
                                    <th>
                                        <button type=\"submit\" onclick=\"solve()\">
                                            預約
                                        </button>
                                    </th>
                                </tr>
                            </form>";
                    }
                } else {
                    echo "<tr><th>片名</th><th>發行時間</th><th>發行公司</th>
                            <th>導演</th><th>演員</th><th>片長</th>
                            <th>語言</th><th>館藏數量</th><th>可借數量</th>
                            <th></th></tr>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<form action=\"reservate_dvd.php\" method=\"get\">
                                <tr style=\"height: 50px\">
                                    <th>
                                        {$row["title"]}
                                        <input type=\"hidden\" id=\"title\" name=\"title\" value=\"{$row["title"]}\">
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
                                        {$row["director"]}
                                    </th>
                                    <th>
                                        {$row["actor"]}
                                    </th>
                                    <th>
                                        {$row["duration"]}
                                    </th>
                                    <th>
                                        {$row["language"]}
                                    </th>
                                    <th>
                                        {$row["tot_qty"]}
                                    </th>
                                    <th>
                                        {$row["avail_qty"]}
                                    </th>
                                    <th>
                                        <button class=\"act-btn\" id=\"reg-btn\">
                                            預約
                                        </button>
                                    </th>
                                </tr>
                            </form>";
                    }
                }
            } else {
                echo "<p>{$option}<br/><p>";
                echo "<p>0 results<br/><p>";
            }
            echo "</div>";
        }else{
            //echo "<p><h2 align='center'><font color='#a66d2f'>資料不完全</font><br/></h2><br/><p>";
        }
    ?>

    <script>
        const searchItem = document.getElementById('search-item');
        const searchBy = document.getElementById('search-by');
        const searchForm = document.getElementById('search-form');

        const options = {
            book: [
                { value: 'title', text: '書名' },
                { value: 'ISBN', text: 'ISBN' },
                { value: 'author', text: '作者' },
                { value: 'genre', text: '類型' }
            ],
            dvd: [
                { value: 'title', text: 'DVD 名稱' },
                { value: 'director', text: '導演' },
                { value: 'genre', text: '類型' }
            ]
        };

        function updateSearchByOptions() {
            const selectedItem = searchItem.value;
            const selectedOptions = options[selectedItem] || [];

            searchBy.innerHTML = '<option value="" disabled selected>搜尋方式</option>'; // Clear existing options and add default option

            selectedOptions.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option.value;
                opt.textContent = option.text;
                searchBy.appendChild(opt);
            });
        }

        // Update options on change
        searchItem.addEventListener('change', updateSearchByOptions);

        // Form submission validation
        searchForm.addEventListener('submit', function(event) {
            if (!searchItem.value || !searchBy.value) {
                event.preventDefault(); // Prevent form submission
                alert('請選擇搜尋選擇及搜尋方式!');
            }
        });

        // Initialize the search-by options on page load
        updateSearchByOptions();

        document.getElementById('reg-btn').addEventListener('click', function() {
            document.getElementById('show').checked = false;
        });

    </script>

</body>
</html>


