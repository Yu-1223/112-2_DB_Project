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

if (isset($_POST['title']) && isset($_POST['release_date']) && isset($_POST['publish_company'])) {
	$dvd_id = $_POST['dvd_id'];
    if ($dvd_id == "") {
        $dvd_id = 1;
    }
    $cutid = explode(",", $dvd_id);
	$title = $_POST['title'];
	$actor = $_POST['actor'];
	$director = $_POST['director'];
    $duration = $_POST['duration'];
    if ($duration == "") {
        $duration = 0;
    }
	$release_date = $_POST['release_date'];
	$genre = $_POST['genre'];
    $cutgen = explode(",", $genre);   
    $nums = count($cutgen);
	$publish_company = $_POST['publish_company'];
	$language = $_POST['language'];

    $nums = count($cutid);
    //echo "nums = " . $nums;
    $max = 0;
    $valid = 1;
    for($x=0; $x < $nums; $x++){
        $check_sql = "select * from dvd
                        where dvd_id={$cutid[$x]};";
        $result = $conn->query($check_sql);
        if ($result->num_rows > 0 || $cutid[$x] < $max) {
            $row = mysqli_fetch_assoc($result);
            //echo "{$row["dvd_id"]}";
            if ($max == 0) {
                $check_sql = "select max(dvd_id) as max
                                from dvd;";
                $result = $conn->query($check_sql);
                if ($result->num_rows == 0) {
                    echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
                    echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
                    //echo "select max dvd_id<br/>";
                    $valid = 0;
                    break;
                } else {
                    $row = mysqli_fetch_assoc($result);
                    //echo "{$row["max"]}" . "<br/>";
                    $max = $row["max"] + 1;
                }
            }
            $cutid[$x] = $max;
            $max = $max + 1;
            //echo $max . "<br/>";
        }
    }
    
    if ($valid == 1)
    {
        $check_sql = "select * from dvd_details
                        where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}';";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            $create_sql = "insert into dvd_details
                            values ('{$title}','{$release_date}','{$publish_company}','{$actor}','{$director}',{$duration},'{$language}',0,0);";
            $result = $conn->query($create_sql);
            //echo $create_sql . "<br/>";
            $check_sql = "select * from dvd_details
                            where title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}' and actor='{$actor}'
                             and director='{$director}' and duration={$duration} and language='{$language}' and tot_qty=0 and avail_qty=0;";
            $result = $conn->query($check_sql);
            //echo $check_sql . "<br/>";
            if ($result->num_rows == 0) {
                echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
                echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
                $valid = 0;
                //echo "insert dvd_details<br/>";
            }
        }
    }
    
    if ($valid == 1) {
	    $nums = count($cutid);
        for($x=0; $x < $nums; $x++){
            $create_sql = "insert into dvd
                            values ({$cutid[$x]},'{$title}','{$release_date}','{$publish_company}');";
            $result = $conn->query($create_sql);
            $check_sql = "select * from dvd
                            where dvd_id={$cutid[$x]} and title='{$title}' and release_date='{$release_date}' and publish_company='{$publish_company}';";
            $result = $conn->query($check_sql);
            if ($result->num_rows == 0) {
                echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
                echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
                $valid = 0;
                //echo "insert dvd_id<br/>";
                break;
            }
        }
    }

    if ($valid == 1) {
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
                    echo "<h2 align='center'><font color='#5b554e'>新增失敗!!</font><br/></h2>";
                    echo "<li><a href=\"create.html\"><font color='#5b554e'>回到上一頁</font></a></li>";
                    $valid = 0;
                    //echo "insert dvd_genre<br/>";
                    break;
                }
            }
        }
    }

    if ($valid == 1)
    {
        echo "<h2 align='center'><font color='#5b554e'>新增成功!!</font><br/></h2>";
        echo "<li><a href=\"create.html\"><font color='#5b554e'>回到上一頁</font></a></li>";
    }

}else{
	echo "<h2 align='center'><font color='#5b554e'>資料不完全</font><br/></h2>";
}
				
?>