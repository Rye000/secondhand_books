<?php
$j = $_POST["j"];   // name
$s = $_POST["s"];   // book_title
$a = $_POST["a"];   // author_name
$b = $_POST["b"];   // price
$c = $_POST["c"];   // quantity
$t = $_POST["t"];   // description
$g = $_POST["g"];   // usage_duration
$d = $_POST["d"];   // created_date
$h = $_POST["h"];   // revise_date
$e = $_POST["e"];   // status

// 連接
require_once "database2.php";

// 時間
$now = date("Y-m-d H:i:s");

if ($_FILES["f"]["error"] == 0) {
    $fileInfo = pathinfo($_FILES["f"]["name"]);
    $fileExt = $fileInfo["extension"]; // 取得檔案副檔名

    // 生成隨機字串
    $randomString = uniqid();

    // 產生新的檔案名稱，以隨機數命名
    $f = $randomString . "." . $fileExt;

    if (move_uploaded_file($_FILES["f"]["tmp_name"], "./img/" . $f)) {
        // 成功上傳圖片
        // 執行插入語句
        $sql = "INSERT INTO `secondhand_books` (`book_id`, `name`, `book_title`, `img`, `author_name`, `price`, `quantity`, `description`, `usage_duration`, `created_date`, `revise_date`, `status`)
                VALUES (NULL, '$j', '$s', '$f', '$a', '$b', '$c', '$t', '$g', '$now', '$now', '$e')";
        $conn->query($sql);
    } else {
        echo "上傳失敗";
        echo "<a href='javascript:window.history.back();'>回上一頁</a>";
    }
}

// 回到首頁
header("Location: TTT.php");
