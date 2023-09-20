<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $j = $_POST["j"];   // name
    $s = $_POST["s"];   // book_title
    $f = $_FILES["f"]["name"];   // img
    $a = $_POST["a"];   // author_name
    $b = $_POST["b"];   // price
    $c = $_POST["c"];   // quantity
    $t = $_POST["t"];   // description
    $g = $_POST["g"];   // usage_duration
    $d = $_POST["d"];   // created_date
    $h = $_POST["h"];   // revise_date
    $e = $_POST["e"];   // status
    $i = $_POST["i"];   // book_id

    require_once "database2.php";

    $now = date("Y-m-d H:i:s");

    // 更新语句
    $sql = "UPDATE `secondhand_books` SET `name`='$j', `book_title`='$s', `author_name`='$a', `price`='$b', `quantity`='$c', `description`='$t', `usage_duration`='$g', `revise_date`='$now', `status`='$e' WHERE `secondhand_books`.`book_id` = '$i'";
    $conn->query($sql);

    if (isset($_FILES['f']) && $_FILES['f']['error'] === UPLOAD_ERR_OK) {
        // 取得檔案資訊
        $fileInfo = pathinfo($_FILES["f"]["name"]);
        $fileExt = $fileInfo["extension"]; // 取得檔案副檔名

        //生成隨機字串
        $randomString = uniqid();
        // 產生新的檔案名稱，以隨機數命名
        $newFileName = $randomString . "." . $fileExt;

        // 新的圖片儲存路徑
        $newPath = 'img/' . $newFileName;

        // 移動上傳的圖片到指定位置
        if (move_uploaded_file($_FILES["f"]["tmp_name"], $newPath)) {
            // 更新資料庫中的圖片路徑
            $sql = "UPDATE `secondhand_books` SET `img`='$newFileName' WHERE `book_id`='$i'";
            $conn->query($sql);
        }
    }

    // 回到首頁
    header("Location: TTT.php");
}
