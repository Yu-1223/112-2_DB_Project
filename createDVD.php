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

if (isset($_POST['title']) && isset($_POST['release_date']) && isset($_POST['publish_company'])) {
	$dvd_id = $_POST['dvd_id'];
    if ($dvd_id == "") {
        $dvd_id = 1;
    }
    $cutid = explode(",", $dvd_id);
	$title = $_POST['title'];
    if ($title == "") {
        $title = "-";
    }
	$actor = $_POST['actor'];
    if ($actor == "") {
        $actor = "-";
    }
	$director = $_POST['director'];
    if ($director == "") {
        $director = "-";
    }
    $duration = $_POST['duration'];
    if ($duration == "") {
        $duration = 0;
    }
	$release_date = $_POST['release_date'];
    if ($release_date == "") {
        $release_date = "000000";
    }
    $release_date = new DateTime("{$release_date}");
    $release_date = $release_date->format('Y-m-d');
	$genre = $_POST['genre'];
    $cutgen = explode(",", $genre);   
    $nums = count($cutgen);
	$publish_company = $_POST['publish_company'];
    if ($publish_company == "") {
        $publish_company = "-";
    }
	$language = $_POST['language'];
    if ($language == "") {
        $language = "-";
    }

    $nums = count($cutid);
    $max = 0;
    $valid = 1;
    for($x=0; $x < $nums; $x++){
        $check_sql = "select * from dvd
                        where dvd_id={$cutid[$x]};";
        $result = $conn->query($check_sql);
        if ($result->num_rows > 0 || $cutid[$x] < $max) {
            $row = mysqli_fetch_assoc($result);
            if ($max == 0) {
                $check_sql = "select max(dvd_id) as max
                                from dvd;";
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
    
    $check_sql = "select * from dvd_details
                    where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}';";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        $create_sql = "insert into dvd_details
                        values ('{$title}','{$release_date}','{$publish_company}','{$actor}','{$director}',{$duration},'{$language}',0,0);";
        $result = $conn->query($create_sql);
        $check_sql = "select * from dvd_details
                        where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}' and actor='{$actor}'
                            and director='{$director}' and duration={$duration} and language='{$language}' and tot_qty=0 and avail_qty=0;";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            $message = "新增失敗";
            $location = "create.php?msg=" . urlencode($message);
            header("Location: " . $location);
        }
    }
    
    $nums = count($cutid);
    for($x=0; $x < $nums; $x++){
        $create_sql = "insert into dvd
                        values ({$cutid[$x]},'{$title}','{$release_date}','{$publish_company}');";
        $result = $conn->query($create_sql);
        $check_sql = "select * from dvd
                        where dvd_id={$cutid[$x]} and title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}';";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            $message = "新增失敗";
            $location = "create.php?msg=" . urlencode($message);
            header("Location: " . $location);
        }
    }

    $nums=count($cutgen);
    for($x=0; $x < $nums; $x++){
        $check_sql = "select * from dvd_genre
                        where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}' and genre='{$cutgen[$x]}';";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            $create_sql = "insert into dvd_genre
                            values ('{$title}','{$release_date}','{$publish_company}','{$cutgen[$x]}');";
            $result = $conn->query($create_sql);
            $check_sql = "select * from dvd_genre
                            where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}' and genre='{$cutgen[$x]}';";
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