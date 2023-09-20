<?php
$id = $_GET["id"];

require_once "database2.php";
//根據id查詢當前商品的詳細信息
$sql = "SELECT * FROM `secondhand_books` WHERE `book_id` = '$id'";

$result = $conn->query($sql);
//獲取商品的具體信息
$res = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+TC:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <title>編輯商品頁面</title>
</head>
<style>
    .error {
        font-size: 10px;
        color: red;
    }

    .box {
        width: 400px;
        /* 固定寬度或最大寬度 */
        margin: auto;
        background-color: #f0f0f0;
        padding: 20px;
    }

    textarea {
        resize: none;
    }

    .image {
        font-size: 100px;
        margin-left: 120px;
    }

    h1 {
        display: flex;
        justify-content: center;
        font-family: 'Noto Serif TC', serif;
    }

    .clickimg {
        transform: transform 3s ease-in-out;
        cursor: pointer;
        color: #ccc;
    }

    .clickimg:hover {
        transform: scale(1.2);
        width: 100px;
        color: black;

    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<body>
    <h1>編輯頁面</h1>
    <div></div>
    <div class="box">
        <form action="go2.php" method="POST" enctype="multipart/form-data">
            <div>
                <input hidden class="form-control" name="i" value="<?php echo $res['book_id']; ?>" type="text"><br>
                <!-- <span>賣家名字:</span>
                <input value="<?php echo $res["name"]; ?>" name="j" type="text" placeholder="賣家名字" id='myname'> 
                <span class="error" id="nameerror"></span><br> -->
                <label for="mybook">書名:</label>
                <input class="form-control" value="<?php echo $res["book_title"]; ?>" name="s" type="text" placeholder="書名" id='mybook'>
                <span class="error" id="bookerror"></span> <br>

                <label for="myname">分類:</label>
                <select name="j" id="myname" class="form-select">
                    <option selected value="請選擇">請選擇</option>
                    <option value="文學與小說" <?php if ($res["name"] === "文學與小說") echo "selected"; ?>>文學與小說</option>
                    <option value="學術與專業" <?php if ($res["name"] === "學術與專業") echo "selected"; ?>>學術與專業</option>
                    <option value="藝術與設計" <?php if ($res["name"] === "藝術與設計") echo "selected"; ?>>藝術與設計</option>
                    <option value="商業與經濟" <?php if ($res["name"] === "商業與經濟") echo "selected"; ?>>商業與經濟</option>
                    <option value="青年與兒童" <?php if ($res["name"] === "青年與兒童") echo "selected"; ?>>青年與兒童</option>
                    <option value="科學與科技" <?php if ($res["name"] === "科學與科技") echo "selected"; ?>>科學與科技</option>
                    <option value="歷史與人文" <?php if ($res["name"] === "歷史與人文") echo "selected"; ?>>歷史與人文</option>
                    <option value="生活與旅遊" <?php if ($res["name"] === "生活與旅遊") echo "selected"; ?>>生活與旅遊</option>
                    <option value="教育與教學" <?php if ($res["name"] === "教育與教學") echo "selected"; ?>>教育與教學</option>
                    <option value="其他" <?php if ($res["name"] === "其他") echo "selected"; ?>>其他</option>
                </select>
                <span class="error" id="nameerror"></span><br>

                <label for="author">作者名字:</label>
                <input class="form-control" name="a" value="<?php echo $res["author_name"]; ?>" type="text" placeholder="作者名字" id='author'>
                <span class="error" id="authorerror"></span><br>

                <label for="price">價格:</label>
                <input class="form-control" name="b" value="<?php echo $res["price"]; ?>" type="number" min="0" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" oninput="if(value.length > 9) value = value.slice(0, 9)" placeholder="價格" id='price'><span class="error" id="priceerror"></span><br>

                <label for="quantity">數量:</label>
                <input class="form-control" name="c" value="<?php echo $res["quantity"]; ?>" type="number" min="0" oninput="if(value.length > 9) value = value.slice(0, 9)" placeholder="數量" id='quantity' onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')">
                <span class="error" id="quantityerror"></span><br>

                <label for="use">使用多久:</label>
                <select name="g" id='use' class="form-select">
                    <option value="請選擇">請選擇</option>
                    <option value="未拆封" <?php if ($res["usage_duration"] === "未拆封") echo "selected"; ?>>未拆封</option>
                    <option value="一年內" <?php if ($res["usage_duration"] === "一年內") echo "selected"; ?>>一年內</option>
                    <option value="三年內" <?php if ($res["usage_duration"] === "三年內") echo "selected"; ?>>三年內</option>
                    <option value="五年以上" <?php if ($res["usage_duration"] === "五年以上") echo "selected"; ?>>五年以上</option>
                </select>
                <span class="error" id="useerror"></span><br>

                <div class="img-wrap">
                    <label for="file1">上傳圖片:</label>
                    <input accept="image/*" type="file" name="f" id="file1" placeholder="圖片" class="form-control form-control-lg">
                    <div>預覽圖片:</div>
                    <div>
                        <img class=" clickimg  bi bi-image-fill image" id="img1" src="img/<?php echo $res['img']; ?>" width="100px" height="150px" alt="" />
                    </div>
                </div>

                <!-- <input name="g" value="<?php echo $res["usage_duration"]; ?>"  type="text" placeholder="使用多久"> -->

                <label for="describe">描述:</label>
                <textarea class="form-control" name="t" id="describe" cols="30" rows="5"><?php echo $res["description"]; ?></textarea>
                <span class="error" id="describeerror"></span><br>

                <span>狀態:</span>
                <input class="form-check-input" type="radio" name="e" id="radio1" value="上架" <?php if ($res["status"] == "上架") echo "checked"; ?>>
                <label for='radio1'>上架</label>
                <input class="form-check-input" type="radio" name="e" id="radio2" value="下架" <?php if ($res["status"] == "下架") echo "checked"; ?>>
                <label for='radio2'>下架</label><br>

                <input type="submit" value="更新商品" id="addd">
                <input type="button" value="取消" id='ano' onclick="goBack()">
            </div>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    //  function goBack() {
    //              window.history.back();
    //         };
    $(function() {
        $('.clickimg').on('click', function() {
            $('#file1').trigger('click');
        });

        $('#file1').on('change', function() {
            $('.clickimg').unbind('click');
            $('#img1').removeClass('clickimg');
        });

        $('#file1').on('change', function() {
            //預覽圖 ***重要
            const reader = new FileReader();
            // load事件表示FileReader物件已經把圖讀完了
            reader.addEventListener('load', event => {
                // console.log(event.target);
                // console.log(event.trigger.result)
                $('#img1').attr('src', event.target.result);
            });
            reader.readAsDataURL(this.files[0]);
        });
        $('#addd').on('click', function(event) {
            $('#nameerror').html('');
            $('#bookerror').html('');
            $('#authorerror').html('');
            $('#priceerror').html('');
            $('#quantityerror').html('');
            $('#useerror').html('');

            if ($('#myname').val() === "請選擇" || $('#mybook').val() === "" || $('#author').val() === "" || $('#price').val() <= 0 || $('#quantity').val() <= 0 || $('#use').val() === "請選擇") {
                Swal.fire({
                    icon: 'error',
                    title: '錯誤',
                    text: '請輸入完整內容!',
                });

                if ($('#myname').val() === "請選擇") {
                    $('#nameerror').html('未輸入分類');
                }
                if ($('#mybook').val() === "") {
                    $('#bookerror').html('未輸入書名');
                }
                if ($('#author').val() === "") {
                    $('#authorerror').html('未輸入作者名字');
                }
                if ($('#price').val() <= 0) {
                    $('#priceerror').html('未輸入價格');
                }
                if ($('#quantity').val() <= 0) {
                    $('#quantityerror').html('未輸入數量');
                }
                if ($('#use').val() === "請選擇") {
                    $('#useerror').html('未輸入使用多久');
                }

                event.preventDefault(); // 阻止表單提交
            } else {
                const bookId = "<?php echo $res['book_id']; ?>";

                event.preventDefault(); // 阻止表單提交

                Swal.fire({
                    title: '更新資料',
                    text: "確定要將資料" + bookId + "更新" + "嗎?",
                    icon: 'warning',
                    showCancelButton: true,
                    iconColor: 'red',
                    confirmButtonColor: 'teool',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            '資料 ' + bookId + ' 更新成功!',
                            '',
                            'success'
                        ).then(function() {
                            // 延遲提交表單，例如延遲 3 秒
                            setTimeout(function() {
                                $('form').submit(); // 自動提交表單
                            }, 300); // 延遲時間，單位為毫秒
                        });
                    }
                });
            }
        });

        //     $(window).on('beforeunload', function() {
        //     return '是否要離開編輯頁面?';
        // });

        $('#ano').on('click', function() {
            Swal.fire({
                title: '是否要離開編輯頁面?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '確定',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        });
    });
</script>

</html>