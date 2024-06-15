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

if (isset($_POST['ISBN'])) {
	$book_id = $_POST['book_id'];
    if ($book_id == "") {
        $book_id = 1;
    }
    $cutid = explode(",", $book_id);
	$ISBN = $_POST['ISBN'];
	$title = $_POST['title'];
    if ($title == "") {
        $title = "-";
    }
	$author = $_POST['author'];
    if ($author == "") {
        $author = "-";
    }
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
    $cutgen = explode(",", $genre);   
    $nums = count($cutgen);
    $version = $_POST['version'];
    if ($version == "") {
        $version = 0;
    }
	$page_num = $_POST['page_num'];
    if ($page_num == "") {
        $page_num = 0;
    }
	$language = $_POST['language'];
    if ($language == "") {
        $language = "-";
    }

    $nums = count($cutid);
    $max = 0;
    $valid = 1;
    for($x=0; $x < $nums; $x++){
        $check_sql = "select * from book
                        where book_id={$cutid[$x]};";
        $result = $conn->query($check_sql);
        if ($result->num_rows > 0 || $cutid[$x] < $max) {
            $row = mysqli_fetch_assoc($result);
            if ($max == 0) {
                $check_sql = "select max(book_id) as max
                                from book;";
                $result = $conn->query($check_sql);
                if ($result->num_rows == 0) {
                    $message = "新增失敗";
                    $location = "create.php?msg=" . urlencode($message);
                    header("Location: " . $location);
                } else {
                    $row = mysqli_fetch_assoc($result);
                    $max = $row["max"] + 1;
                }
            }
            $cutid[$x] = $max;
            $max = $max + 1;
        }
    }
    
    $check_sql = "select * from book_details
                    where ISBN = '{$ISBN}';";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        $create_sql = "insert into book_details
                        values ('{$ISBN}','{$title}','{$author}','{$publisher}','{$publish_date}',{$version},{$page_num},'{$language}',0,0);";
        $result = $conn->query($create_sql);
        $check_sql = "select * from book_details
                        where ISBN='{$ISBN}' and title='{$title}' and author='{$author}' and publisher='{$publisher}' and publish_date='{$publish_date}' 
                        and version={$version} and page_num={$page_num} and language='{$language}' and tot_qty=0 and avail_qty=0;";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            $message = "新增失敗";
            $location = "create.php?msg=" . urlencode($message);
            header("Location: " . $location);
        }
    }
    
    $nums = count($cutid);
    for($x=0; $x < $nums; $x++){
        $create_sql = "insert into book
                        values ({$cutid[$x]},'{$ISBN}');";
        $result = $conn->query($create_sql);
        $check_sql = "select * from book
                        where book_id={$cutid[$x]} and ISBN='{$ISBN}';";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            $message = "新增失敗";
            $location = "create.php?msg=" . urlencode($message);
            header("Location: " . $location);
        }
    }

    $nums=count($cutgen);
    for($x=0; $x < $nums; $x++){
        $check_sql = "select * from book_genre
                        where ISBN='{$ISBN}' and genre='{$cutgen[$x]}';";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            $create_sql = "insert into book_genre
                            values ('{$ISBN}','{$cutgen[$x]}');";
            $result = $conn->query($create_sql);
            $check_sql = "select * from book_genre
                            where ISBN='{$ISBN}' and genre='{$cutgen[$x]}';";
            $result = $conn->query($check_sql);
            if ($result->num_rows == 0) {
                $message = "新增失敗";
                $location = "create.php?msg=" . urlencode($message);
                header("Location: " . $location);
            }
        }
    }

    $message = "新增成功";
	$location = "create.php?msg=" . urlencode($message);
	header("Location: " . $location);
}else{
	$message = "新增失敗";
    $location = "create.php?msg=" . urlencode($message);
    header("Location: " . $location);
}
				
?>