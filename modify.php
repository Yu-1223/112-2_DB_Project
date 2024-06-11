<?php
include 'session.php';
session_start();
// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="modify.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-title">
            <img src="lion.png" alt="Icon" class="navbar-icon">獅大圖書館管理系統</div>
        <ul class="nav-list">
            <li><a href="delete.php">刪除資料</a></li>
            <li><a href="update.php">更新資料</a></li>
            <li><a href="create.php">新增資料</a></li>
        </ul>
    </nav>

    <div class="home-content">
        <div class="home-image">
            <img src="home.jpg" alt="Image"  width="auto" height="480">
        </div>       
        <div class="home-text">
            <h1>歡迎使用獅大圖書館管理系統!</h1>
            <p>刪除資料:</P>
            <p class="detail">- 點擊刪除資料可以刪除資料</P>
            <p class="detail">- 點擊對應的項目按下刪除即可刪除</P>
            <p>更新資料:</P>
            <p class="detail">- 點擊刪除資料可以更新資料</P>
            <p class="detail">- 點擊對應的項目填入資料後即可更新</P>
            <p>新增資料:</P>
            <p class="detail">- 點擊新增資料可以更新資料</P>
            <p class="detail">- 在對應的表格輸入資料後即可更新</P>
        </div>
    </div>

    <form action="logout.php" method="post">
            <button class="logout-button" type="submit">Logout</button>
    </form>
</body>
</html>