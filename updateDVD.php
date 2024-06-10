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

$dvd_id_o = $_POST['dvd_id_o'];
$title_o = $_POST['title_o'];
$actor_o = $_POST['actor_o'];
$actor_o = str_replace("'", "''", $actor_o);
$director_o = $_POST['director_o'];
$director_o = str_replace("'", "''", $director_o);
$release_date_o = $_POST['release_date_o'];
$genre_o = $_POST['genre_o'];
$duration_o = $_POST['duration_o'];
$publish_company_o = $_POST['publish_company_o'];
$language_o = $_POST['language_o'];
$dvd_id = $_POST['dvd_id'];
$title = $_POST['title'];
$actor = $_POST['actor'];
$actor = str_replace("'", "''", $actor);
$director = $_POST['director'];
$director = str_replace("'", "''", $director);
$release_date = $_POST['release_date'];
$genre = $_POST['genre'];
if ($_POST['duration'] == "") {
    $duration = 0;
} else {
    $duration = $_POST['duration'];
}
$publish_company = $_POST['publish_company'];
$language = $_POST['language'];

$update_sql = "update dvd_details
                set title='{$title}', actor='{$actor}', director='{$director}', release_date='{$release_date}', duration={$duration}, publish_company='{$publish_company}', language='{$language}'
                where title='{$title_o}' and actor='{$actor_o}' and director='{$director_o}' and release_date='{$release_date_o}' and duration={$duration_o} and publish_company='{$publish_company_o}' and language='{$language_o}';";
$result = $conn->query($update_sql);
$check_sql = "select * from dvd_details
                where title='{$title}' and actor='{$actor}' and director='{$director}' and release_date='{$release_date}' and duration={$duration} and publish_company='{$publish_company}' and language='{$language}';";
$result1 = $conn->query($check_sql);

$valid = 1;
if ($genre == "") {
    $update_sql = "delete from dvd_genre
                    where title='{$title_o}' and release_date='{$release_date_o}' and publish_company='{$publish_company_o}' and genre='{$genre_o}';";
    $result = $conn->query($update_sql);
    $check_sql = "select * from dvd_genre
                    where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}' and genre='{$genre}';";
    $result3 = $conn->query($check_sql);
    if ( $result3->num_rows > 0) {
        $valid = 0;
    } 
} else {
    $update_sql = "update dvd_genre
                    set title='{$title}', release_date='{$release_date}', publish_company='{$publish_company}', genre='{$genre}'
                    where title='{$title_o}' and release_date='{$release_date_o}' and publish_company='{$publish_company_o}' and genre='{$genre_o}';";
    $result = $conn->query($update_sql);
    $check_sql = "select * from dvd_genre
                    where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}' and genre='{$genre}';";
    $result3 = $conn->query($check_sql);
    if ( $result3->num_rows == 0) {
        $valid = 0;
    } 
}


if ($result1->num_rows == 0 || $valid == 0) {
    echo "<h2 align='center'><font color='#5b554e'>修改失敗!!</font></h2>";
    echo "<li><a href=\"updateDVD_details.php\"><font color='#5b554e'>回到上一頁</font></a></li>";
} else {
    echo "<h2 align='center'><font color='#5b554e'>修改成功!!</font></h2>";
    echo "<li><a href=\"update.php\"><font color='#5b554e'>回到上一頁</font></a></li>";
}

				
?>
