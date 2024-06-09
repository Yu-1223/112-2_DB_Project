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

    <div class="content">
        <h2>Welcome to the Home Page</h2>
        <p>This is the main content of the home page.</p>
        <?php
            session_start();
            $user_id = $_SESSION["ID"];
        ?>
    </div>
</body>
</html>
