<?php
//撰寫新增消費發票的程式碼
//將發票的號碼及相關資訊寫入資料庫

// foreach($_POST as $key => $value){
//     echo "欄位".$key."==值" .$value."<br>";把此行換成下面方式:將變數輸出結果再丟入
//     $tmp[]=$key;
//   }

include_once "../base.php";


echo "<pre>";
print_r(array_keys($_POST));
echo "</pre>";


$sql="insert into invoices (`".implode("`,`",array_keys($_POST))."`) values('".implode("','",$_POST)."')";
//insert 前為""指欄位名稱，value內為值放單引號''
echo $sql;
$pdo->exec($sql); //exec為新增一筆資料

echo "新增完成";
// header("location:../index.php"); 
//此檔案位於上一層


?>