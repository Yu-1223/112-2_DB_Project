<?php

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

$book_id_o = $_POST['book_id_o'];
$ISBN_o = $_POST['ISBN_o'];
$title_o = $_POST['title_o'];
$author_o = $_POST['author_o'];
$author_o = str_replace("'", "''", $author_o);
$publisher_o = $_POST['publisher_o'];
$publish_date_o = $_POST['publish_date_o'];
$publish_date_o = new DateTime("{$publish_date_o}");
$publish_date_o = $publish_date_o->format('Y-m-d');
$genre_o = $_POST['genre_o'];
$version_o = $_POST['version_o'];
$page_num_o = $_POST['page_num_o'];
$language_o = $_POST['language_o'];
$book_id = $_POST['book_id'];
$ISBN = $_POST['ISBN'];
$title = $_POST['title'];
if ($title == "") {
    $title = "-";
}
$author = $_POST['author'];
if ($author == "") {
    $author = "-";
}
$author = str_replace("'", "''", $author);
$publisher = $_POST['publisher'];
if ($publisher == "") {
    $publisher = "-";
}
$publish_date = $_POST['publish_date'];
if ($publish_date == "") {
    $publish_date = "000000";
}
$publish_date = new DateTime("{$publish_date}");
$publish_date = $publish_date->format('Y-m-d');
$genre = $_POST['genre'];
if ($_POST['version'] == "") {
    $version = 0;
} else {
    $version = $_POST['version'];
}
if ($_POST['page_num'] == "") {
    $page_num = 0;
} else {
    $page_num = $_POST['page_num'];
}
$language = $_POST['language'];
if ($language == "") {
    $language = "-";
}

$update_sql = "update book_details
                set ISBN='{$ISBN}', title='{$title}', author='{$author}', publisher='{$publisher}', publish_date='{$publish_date}', version={$version}, page_num={$page_num}, language='{$language}'
                where ISBN='{$ISBN_o}' and title='{$title_o}' and author='{$author_o}' and publisher='{$publisher_o}' and publish_date='{$publish_date_o}' and version={$version_o} and page_num={$page_num_o} and language='{$language_o}';";
$result = $conn->query($update_sql);
$check_sql = "select * from book_details
                where ISBN='{$ISBN}' and title='{$title}' and author='{$author}' and publisher='{$publisher}' and publish_date='{$publish_date}' and version={$version} and page_num={$page_num} and language='{$language}';";
$result1 = $conn->query($check_sql);

$valid = 1;
if ($genre == "") {
    $update_sql = "delete from book_genre
                    where ISBN='{$ISBN}' and genre='{$genre_o}';";
    $result = $conn->query($update_sql);
    $check_sql = "select * from book_genre
                    where ISBN='{$ISBN}' and genre='{$genre_o}';";
    $result3 = $conn->query($check_sql);
    if ( $result3->num_rows > 0) {
        $valid = 0;
    } 
} else {
    $update_sql = "update book_genre
                    set ISBN='{$ISBN}', genre='{$genre}'
                    where ISBN='{$ISBN}' and genre='{$genre_o}';";
    $result = $conn->query($update_sql);
    $check_sql = "select * from book_genre
                    where ISBN='{$ISBN}' and genre='{$genre}';";
    $result3 = $conn->query($check_sql);
    if ( $result3->num_rows == 0) {
        $valid = 0;
    } 
}

if ($result1->num_rows == 0 || $valid == 0) {
    $message = "修改失敗";
    $location = "updateBook_details.php?msg=" . urlencode($message);
    header("Location: " . $location);
} else {
    $message = "修改成功";
    $location = "update.php?msg=" . urlencode($message);
    header("Location: " . $location);
}

				
?>
