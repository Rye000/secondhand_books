<?php 
//連接數據庫
$conn = new mysqli("localhost", "root", "", "topic");

//判斷
if ($conn->connect_error) {
    die("連接失敗");
}
