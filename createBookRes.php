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

if (isset($_POST['user_id']) && isset($_POST['book_id']) && isset($_POST['estimation_date'])) {
	$user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $queue = $_POST['queue'];
    if ($queue == "") {
        $queue = 1;
    }
	$estimation_date = $_POST['estimation_date'];
    
    $valid = 1;
    $check_sql = "select * from book
                    where book_id = {$book_id};";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
        echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
        $valid = 0;
        //echo "insert book_details<br/>";
    }
    if ($valid == 1) {
        $check_sql = "select * from user
                        where user_id = {$user_id};";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
            echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
            $valid = 0;
            //echo "insert book_details<br/>";
        }
    }
    
    if ($valid == 1) {
	    $create_sql = "insert into book_reservation
                        values ({$user_id},{$book_id},{$queue},'{$estimation_date}');";
        $result = $conn->query($create_sql);
        $check_sql = "select * from book_reservation
                        where user_id={$user_id} and book_id={$book_id} and queue={$queue} and estimation_date='{$estimation_date}';";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            echo "<h2 align='center'><font color='#a66d2f'>新增失敗!!</font><br/></h2>";
            echo "<h2 align='center'><font color='#a66d2f'>請回到上一頁</font><br/></h2>";
            $valid = 0;
            //echo "insert book_id<br/>";
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