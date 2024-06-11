<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-title">
            <img src="lion.png" alt="Icon" class="navbar-icon">獅大圖書館</div>
        <ul class="nav-list">
            <?php
                echo "<li><a href=\"search.php\">館藏搜尋</a></li>";
                echo "<li><a href=\"activity.html\">活動報名</a></li>";
                echo "<li><a href=\"profile.php\">個人資料</a></li>";
            ?>
        </ul>
    </nav>

    <div class="home-content">
        <div class="home-image">
            <img src="home.jpg" alt="Image"  width="auto" height="480">
        </div>       
        <div class="home-text">
            <h1>歡迎使用獅大圖書館網站!</h1>
            <p>館藏搜尋:</P>
            <p class="detail">- 點擊館藏搜尋可以依據類別搜尋書籍和DVD</P>
            <p class="detail">- 點擊預約即可預約書籍或DVD</P>
            <p>活動報名:</P>
            <p class="detail">- 點擊活動報名可預覽目前可報名之活動</P>
            <p class="detail">- 點擊活動詳情後輸入活動資料即可報名活動</P>
            <p>個人資料:</P>
            <p class="detail">- 點擊個人資料可檢視個資或修改個資</P>
            <p class="detail">- 也可預覽已報名之活動和已預約之書籍及DVD</P>
        </div> 
        <?php
            session_start();
            $user_id = $_SESSION["ID"];
        ?>
    </div>
</body>
</html>
