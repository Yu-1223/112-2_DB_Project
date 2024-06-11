<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
        session_start();
        $user_id = $_SESSION["ID"];
        date_default_timezone_set('Asia/Taipei');

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

        if (isset($_GET['ISBN'])) {
            $ISBN = $_GET['ISBN'];
            //echo $ISBN . "<br/>";

            $valid = 1;
            $user_sql = "select * from user
                            where user_id={$user_id};";
            $user_info = $conn->query($user_sql);
            if ($user_info->num_rows > 0) {
                $user_row = mysqli_fetch_assoc($user_info);
                $full_name = $user_row["full_name"];
                //echo $full_name . "<br/>";
            } else {
                $valid = 0;
                echo "<h2 align='center'><font color='#a66d2f'>預約失敗!!</font></h2>";
            }
            //echo $full_name . "<br/>";
            
            if ($valid == 1) {
                $reser_sql = "select book_id, max(queue) as max
                                from book_reservation natural join book natural join book_details
                                where ISBN='{$ISBN}'
                                group by book_id;";
                $reser = $conn->query($reser_sql);
                if ($reser->num_rows > 0) {
                    $min = 10000;
                    $min_id = "";
                    while ($res_row = mysqli_fetch_assoc($reser)) {
                        if ($res_row["max"] < $min) {
                            $min = $res_row["max"];
                            $min_id = $res_row["book_id"];
                        }
                    }
                    $reser_sql = "select book_id, queue as min, estimation_date
                                    from book_reservation natural join book natural join book_details
                                    where book_id={$min_id} and queue={$min};";
                    $reser = $conn->query($reser_sql);
                    $res_row = mysqli_fetch_assoc($reser);
                    $res_row["min"] = $res_row["min"] + 1;
                    $res_row["estimation_date"] = new DateTime("{$res_row["estimation_date"]}");
                    // Add 30 days to the date
                    $res_row["estimation_date"]->modify('+30 days');
                    // Format the date to 'Y-m-d'
                    $res_row["estimation_date"] = $res_row["estimation_date"]->format('Y-m-d');
                } else {
                    $today = date("Y-m-d");
                    $reser_sql = "select book_id
                                    from book
                                    where ISBN='{$ISBN}';";
                    $reser = $conn->query($reser_sql);
                    if ($reser->num_rows > 0) {
                        $res_row = mysqli_fetch_assoc($reser);
                        $res_row += ["min" => 1, "estimation_date" => $today];
                    } else {
                        $valid = 0;
                        echo "<h2 align='center'><font color='#a66d2f'>預約失敗!!</font></h2>";
                    }
                }
            }

            if ($valid == 1) {
                $book_id = $res_row["book_id"];
                $queue = $res_row["min"];
                $estimation_date = $res_row["estimation_date"];
                //$estimation_date = new DateTime("{$estimation_date}");
                //$estimation_date = $estimation_date->format('Y-m-d');

                $insert_sql = "insert into book_reservation
                                values ({$user_id},{$book_id},{$queue},'{$estimation_date}');";
                $insert = $conn->query($insert_sql);
                $insert_sql = "select * from book_reservation
                                where user_id={$user_id} and book_id={$book_id} and queue={$queue} and estimation_date='{$estimation_date}';";
                $insert = $conn->query($insert_sql);

                $reser_sql = "select title
                                from book natural join book_details
                                where book_id={$book_id};";
                $reser = $conn->query($reser_sql);
                if ($reser->num_rows == 0) {
                    $res_row = mysqli_fetch_assoc($reser);
                    $title = $res_row["title"];
                } else {
                    $title = "-";
                }

            }
            
            if ($valid == 1) {
                if ($insert->num_rows > 0) {
                    echo "<div class=\"profile\">";
                    echo "<h2 align='center'><font color='#a66d2f'>預約成功!!</font></h2>";
                    echo "<table style='font-family:\"Courier New\", Courier, monospace; font-size:20px;text-align: left; width:100%' align=\"left\">";
                    echo "<tr style=\"height:45px\"><th>姓名: </th><th colspan=\"2\">{$full_name}</th></tr>";
                    echo "<tr style=\"height:45px\"><th>書名: </th><th colspan=\"2\">{$title}</th></tr>";
                    echo "<tr style=\"height:45px\"><th>序列: </th><th colspan=\"2\">{$queue}</th></tr>";
                    echo "<tr style=\"height:45px\"><th>預計日期: </th><th colspan=\"2\">{$estimation_date}</th></tr>";
                    echo "<li><a href=\"search.php\"><font color='#a66d2f'>回到上一頁</font></a></li>";
                    echo "</div>";
                } else {
                    echo "<h2 align='center'><font color='#a66d2f'>預約失敗!!</font></h2>";
                }
            }
        }else{
            echo "<h2 align='center'><font color='#a66d2f'>資料不完全</font><br/></h2>";
        }
                    
    ?>
</body>
</html>
