<?php include_once "base.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>統一發票紀錄及對獎系統</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .number{
            font-size:1.2rem;
            font-weight:bolder;
            color:red;
        }
    </style>
</head>
<body>



<h3 class="text-center m-3"> 統一發票紀錄與對獎 </h3>

<div class="container">
<div class="col-lg-8 col-md-12 d-flex justify-content-between p-3 mx-auto border rounded bg-info text-white">
<?php
    $month=[
        1=>"1,2月",
        2=>"3,4月",
        3=>"5,6月",
        4=>"7,8月",
        5=>"9,10月",
        6=>"11,12月",
    ];

    $m=ceil(date("m")/2);

?>
    <div class="text-center"><?=$month[$m];?></div>
    <div class="text-center">
        <a href="?do=invoice_list&start=1" class="bg-warning text-white border-none rounded">當期發票</a>
    </div>
    <div class="text-center">
        <a href="?do=award_numbers" class="bg-warning text-white border-none rounded">發財時間</a>
    </div>
    <div class="text-center">
        <a href="?do=add_awards" class="bg-warning text-white border-none rounded">輸入開獎獎號</a>
    </div>
    <div class="text-center">
        <a href="index.php" class="bg-warning text-white border-none rounded">回首頁</a>
    </div>
</div>

<div class="col-lg-8 col-md-12 d-flex flex-column p-3 mx-auto border">
<?php

    if(isset($_GET['do'])){

        $file=$_GET['do'].".php";
        
        include $file;


    }else{

        include "main.php";
    }

    ?>
</div>

</div>
</body>
</html>
<?php $_SESSION['err']=[];?>  <!-- 每次都清空暫存值 -->