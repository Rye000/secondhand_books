<?php
$id = $_POST["id"];


//引入文件
require_once "database2.php";

//刪除sql
//去phpmyadmin 刪除1個找語句
$sql ="DELETE FROM secondhand_books WHERE `secondhand_books`.`book_id` = $id";

//執行sql
$conn->query($sql);


//回到首頁
header("Location:TTT.php");
