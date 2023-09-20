<?php
require_once "database2.php";

// 註解掉分頁相關程式碼
/*
$pageRow_records = 5;
$num_pages = 1;

if (isset($_GET['page'])) {
    $num_pages = $_GET['page'];
}

$startRow_records = ($num_pages - 1) * $pageRow_records;

$sql_query = "SELECT * FROM secondhand_books ";

$sql_query_limit = $sql_query . " LIMIT {$startRow_records}, {$pageRow_records}";

$result = $conn->query($sql_query_limit);

$all_result = $conn->query($sql_query);

$total_records = $all_result->num_rows;
$total_pages = ceil($total_records / $pageRow_records);
*/

// 只保留計算總筆數的程式碼
$sql_query = "SELECT COUNT(*) AS total_records FROM secondhand_books";
$result = $conn->query($sql_query);
$row = $result->fetch_assoc();
$total_records = $row['total_records'];

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
    <title>商品頁面</title>
    <style>
        .abc {
            width: 50px;
            height: 50px;
            color: pink;
        }


        .purple {
            color: purple;
            font-weight: bold;
        }

        .red {
            color: red;
            font-weight: bold;
        }

        .box {
            margin: auto;
        }

        .box2 {
            display: flex;
            justify-content: center;
            font-family: 'Noto Serif TC', serif;
            font-size: 30px;
            margin-top: 20px;
        }

        /* .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 5px;
            background-color: #eaeaea;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #ccc;
        }

        .pagination .active {
            background-color: #333;
            color: #fff; 
        } */

        table,
        th,
        td {
            border: 1px solid black;
        }

        h1 {
            text-align: center;
            font-family: 'Noto Serif TC', serif;
        }

        th,
        td {
            text-align: center;
            vertical-align: baseline;

        }



        /* .disabled-link {
            pointer-events: none;
            cursor: default;
            text-decoration: none;
            color: #ccc;
        } */

        .description1 {
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .mybook {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dataTables_paginate {
            width: 100%;
            text-align: center;
        }

        .add0 {
            margin: 10px;
            display:
                inline-block;
            padding: 5px 10px;
            background: #ccc;
            border-radius: 20px;
            /*框線的*/
            font-size: 20px;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(to bottom, #fff, #ccc 30%, #ddd 30%, #000 50%, #666, 80%, #ddd);
            font-weight: bold;
            color: #fff;
            /*文字的顏色*/
            text-shadow: 0 -1px 0 #000;
            /*text-shadow: 0(水平位移) -1px(垂垂直位移) 0(模糊程度) #000(顏色); */
            box-shadow: 0 0 8px #333, 0 0 9px #fff inset;
            /*陰影box-shadow: 0(水平位移) 0(垂直位移) 5px(模糊程度) #333(顏色) */
            text-decoration: none;
            /*去除底線*/
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .add0:hover {
            background: linear-gradient(to bottom, #eee, #aaa 30%, #bbb 30%, #000 50%, #444, 80%, #bbb);
            font-family: Arial, Helvetica, sans-serif;
            box-shadow: 0 0 5px #333, 0 2px #fff inset;
            transform: translateY(-10px)
        }

        .edit {
            background-image: linear-gradient(to right, #20002c 0%, #cbb4d4 51%, #20002c 100%);
            text-align: center;
            text-transform: uppercase;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            box-shadow: 0 0 20px #eee;
            border-radius: 10px;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .edit:hover {
            background-position: right center;
            /* change the direction of the change here */
            color: #fff;
            text-decoration: none;
            transform: translateY(-5px);

        }

        .del1 {
            background-image: linear-gradient(to right, #ff0084 0%, #33001b 51%, #ff0084 100%);
            text-align: center;
            text-transform: uppercase;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            box-shadow: 0 0 20px #eee;
            border-radius: 10px;
        }

        .del1:hover {
            background-position: right center;
            /* change the direction of the change here */
            color: #fff;
            text-decoration: none;
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16" style="display: none;">
        <path id="left" fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
    </svg>
    <h1>二手書商品頁面</h1>
    <!--資料表 -->
    <div class="box2">
        <p>目前資料筆數:<?php echo $total_records; ?></p>
    </div>
    <div><a class="btn btn-primary  add0" href="add2.html">添加新商品</a></div>
    <table class="table" id="example">
        <thead class="table-dark">
            <tr class="th1">
                <th class="text-nowrap">ID</th>
                <th class="text-nowrap ">書名</th>
                <th class="text-nowrap" style="width:100px">分類</th>
                <th class="text-nowrap" style="width:100px">圖片</th>
                <th class="text-nowrap" style="width:130px">作者名字</th>
                <th class="text-nowrap">價格</th>
                <th class="text-nowrap">數量</th>
                <th class="text-nowrap" style="width:200px">描述</th>
                <th class="text-nowrap" style="width:50px">使用多久</th>
                <th class="text-nowrap" style="width:175px;">建立日期</th>
                <th class="text-nowrap" style="width:175px;">最後修改日期</th>
                <th class="text-nowrap">狀態</th>
                <th style="width: 150px; " class="text-nowrap">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //查詢所有數據的sql語句
            $sql = "SELECT * FROM `secondhand_books`";
            //執行sql語句
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
            ?>
                <tr class="th1">
                    <td><?php echo $row["book_id"]; ?></td><!--ID-->
                    <td class="mybook"><?php echo $row["book_title"]; ?></td><!--書名-->
                    <td style="width:80px"><?php echo $row["name"]; ?></td><!--分類-->
                    <td><img src="img/<?php echo $row['img']; ?>" width="48" height="64" alt="" /></td><!--圖片-->
                    <td class="description1"><?php echo $row["author_name"]; ?></td><!--作者名字-->
                    <td><?php echo $row["price"]; ?></td> <!--價格-->
                    <td><?php echo $row["quantity"]; ?></td> <!--數量-->
                    <td class="description1"><?php echo $row["description"]; ?></td><!--描述-->
                    <td><?php echo $row["usage_duration"]; ?></td><!--使用多久-->
                    <td><?php echo $row["created_date"]; ?></td><!--建立日期-->
                    <td><?php echo $row["revise_date"]; ?></td><!--最後更改日期-->
                    <td class="<?php echo $row["status"] === '上架' ? 'purple' : 'red'; ?>"><?php echo $row["status"]; ?></td>
                    <!--上下架-->
                    <td style="width:110px ; ">
                        <a class="btn btn-dark edit" href="edit2.php?id=<?php echo $row['book_id'] ?>">編輯</a>
                        <button class="btn btn-danger delete-btn del1" data-bookid="<?php echo $row['book_id']; ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">刪除</button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <!-- <table border="0" class="box">
        <tr>
            <?php if ($num_pages > 1) { //若不是第一頁顯示 
            ?>
                 <td><a href="TTT.PHP?page=1">第一頁</a> </td> 
                <td><a href="TTT.PHP?page=<?php echo $num_pages - 1; ?>">上一頁</a> </td>
            <?php } else { ?> <td><a class="disabled-link" href="">上一頁</a></td>
            <?php  } ?>

            <?php if ($num_pages < $total_pages) { //若不是最後一頁則顯示 
            ?>
                <td><a href="TTT.PHP?page=<?php echo $total_pages; ?>">最後頁</a> </td> 
                <td><a class="bi bi bi-arrow-left-circle" href="TTT.PHP?page=<?php echo $num_pages + 1; ?>">下一頁</a> </td>
            <?php } else { ?> <td><a class="disabled-link " href="">下一頁</a></td>
            <?php  } ?>
        </tr>
    </table> -->
    <!--- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

    <!-- 分頁部分-->
    <!-- <table border="0" class="box">
         <tr>
            <?php if ($num_pages > 1) { //若不是第一頁顯示 
            ?> -->
    <!-- <td><a href="TTT.PHP?page=1">第一頁</a> </td> -->
    <!-- <td><a class="bi bi-arrow-left-circle icons" href="TTT.PHP?page=<?php echo $num_pages - 1; ?>"></a> </td> -->
    <!--上一頁 -->
    <!-- <?php } else { ?> <td><a class="disabled-link bi bi-arrow-left-circle icons" href=""></a></td> -->
    <!--上一頁 -->
    <!-- <?php  } ?>

            <td> 
                <div class="pagination"> -->
    <!-- 頁數: -->
    <!-- <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $num_pages) {
                    echo $i . " ";
                } else {
                    echo "<a href=\"TTT.PHP?page={$i}\">{$i}</a>";
                }
            }
            ?>
                </div>
            </td> -->
    <!-- <?php if ($num_pages < $total_pages) { //若不是最後一頁則顯示 
            ?> -->
    <!-- <td><a href="TTT.PHP?page=<?php echo $total_pages; ?>">最後頁</a> </td>  -->
    <!-- <td><a class="bi bi bi-arrow-right-circle icons" href="TTT.PHP?page=<?php echo $num_pages + 1; ?>"></a> </td> -->
    <!--下一頁 -->
    <!-- <?php } else { ?> <td><a class="disabled-link bi bi-arrow-right-circle icons" href=""></a></td> -->
    <!--下一頁 -->
    <!-- <?php  } ?>
        </tr>
    </table>  -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">刪除資料</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    你確定要刪除資料嗎?
                </div>
                <div class="modal-footer">
                    <button id="confirm-delete-btn" type="button" class="btn btn-primary">確定</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            //刪除資料
            let deleteBookId = null;

            $(".delete-btn").click(function() {
                deleteBookId = $(this).data("bookid");
                $('#exampleModal .modal-body').text('確定要將資料' + deleteBookId + "刪除" + '嗎?');
            });

            $("#confirm-delete-btn").click(function() {
                if (deleteBookId) {
                    $.ajax({
                        url: "del2.php",
                        type: "POST",
                        data: {
                            id: deleteBookId
                        },
                        success: function(response) {
                            Swal.fire({
                                position: 'content',
                                icon: 'success',
                                title: deleteBookId + ' 資料刪除成功',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });
            $(function() {
                $('#example').DataTable({
                    language: {
                        "sEmptyTable": "目前資料庫中沒有可用的資料",
                        "sSearch": "搜尋:",
                        "sZeroRecords": "找不到符合的資料",
                        "lengthMenu": "顯示 _MENU_ 筆資料",
                        "oPaginate": {
                            "sNext": "下一頁",
                            "sPrevious": "上一頁"
                        }
                    },
                    info: false,
                    lengthMenu: [5, 10, 25, 50],
                    columnDefs: [{
                            targets: [1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12], // 要移除排序功能的欄位索引
                            orderable: false // 移除升降排序功能
                        },
                        // 如果還有其他欄位需要設定，可以在此新增相對應的物件
                        // { targets: [1, 3], orderable: false },
                    ],
                    drawCallback: function(settings) {
                        const pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                        pagination.css('text-align', 'center');
                        pagination.css('float', 'none');
                        const searchWrapper = $(this).closest('.dataTables_wrapper').find('.dataTables_filter');
                        searchWrapper.css('text-align', 'center');
                        searchWrapper.css('float', 'none');
                    }
                });
            });
        });
    </script>
</body>

</html>