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

if (isset($_POST['ISBN'])) {
	$book_id = $_POST['book_id'];
    if ($book_id == "") {
        $book_id = 1;
    }
    $cutid = explode(",", $book_id);
	$ISBN = $_POST['ISBN'];
	$title = $_POST['title'];
	$author = $_POST['author'];
	$publisher = $_POST['publisher'];
	$publish_date = $_POST['publish_date'];
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

    $nums = count($cutid);
    //echo "nums = " . $nums;
    $max = 0;
    $valid = 1;
    for($x=0; $x < $nums; $x++){
        $check_sql = "select * from book
                        where book_id={$cutid[$x]};";
        $result = $conn->query($check_sql);
        if ($result->num_rows > 0 || $cutid[$x] < $max) {
            $row = mysqli_fetch_assoc($result);
            //echo "{$row["book_id"]}";
            if ($max == 0) {
                $check_sql = "select max(book_id) as max
                                from book;";
                $result = $conn->query($check_sql);
                if ($result->num_rows == 0) {
                    echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
                    echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
                    //echo "select max book_id<br/>";
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
        $check_sql = "select * from book_details
                        where ISBN = '{$ISBN}';";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            $create_sql = "insert into book_details
                            values ('{$ISBN}','{$title}','{$author}','{$publisher}','{$publish_date}',{$version},{$page_num},'{$language}',0,0);";
            $result = $conn->query($create_sql);
            //echo $create_sql . "<br/>";
            $check_sql = "select * from book_details
                            where ISBN='{$ISBN}' and title='{$title}' and author='{$author}' and publisher='{$publisher}' and publish_date='{$publish_date}' 
                            and version={$version} and page_num={$page_num} and language='{$language}' and tot_qty=0 and avail_qty=0;";
            $result = $conn->query($check_sql);
            //echo $check_sql . "<br/>";
            if ($result->num_rows == 0) {
                echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
                echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
                $valid = 0;
                //echo "insert book_details<br/>";
            }
        }
    }
    
    if ($valid == 1) {
	    $nums = count($cutid);
        for($x=0; $x < $nums; $x++){
            $create_sql = "insert into book
                            values ({$cutid[$x]},'{$ISBN}');";
            $result = $conn->query($create_sql);
            $check_sql = "select * from book
                            where book_id={$cutid[$x]} and ISBN='{$ISBN}';";
            $result = $conn->query($check_sql);
            if ($result->num_rows == 0) {
                echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
                echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
                $valid = 0;
                //echo "insert book_id<br/>";
                break;
            }
        }
    }

    if ($valid == 1) {
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
                    echo "<h2 align='center'><font color='#5b554e'>新增失敗!!</font><br/></h2>";
                    echo "<li><a href=\"create.html\"><font color='#5b554e'>回到上一頁</font></a></li>";
                    $valid = 0;
                    //echo "insert book_genre<br/>";
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