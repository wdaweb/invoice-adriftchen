<?php
//單一發票對獎

include_once "base.php";

//最好檢查get是否有撈到資料，是否帶錯誤特殊符號
$inv_id=$_GET['id'];

//這裡出現fatal error
//把這行select丟回phpmyadmin看錯誤訊息
//必須在該行之前echo 才看的到
// echo "select * from invoices where id='$inv_id'";
$invoice=$pdo->query("select * from invoices where id='$inv_id'")->fetch();
$number=$invoice['number'];

//把資料庫叫出來的東西以陣列印出來看
// echo "<pre>";
// print_r($invoice);
// echo "</pre>";

//找出獎號
//1.確認期數->分析目前發票日期
//2.得到期數資料後->撈出該期的開獎號

$date=$invoice['date'];
//explode('-',$date)取得日期資料的陣列，陣列的第二個元素即月份->可推算期數、年份->可找開獎號
//$array=explode('-',$date)
//$month=$array[1]
//$period=ceil($month/2)

$year=explode('-',$date)[0];
$period=ceil((explode('-',$date)[1])/2);
//print_r($explode) 可看一下結果

echo "select * from award_numbers where year='$year' && period='$period'";
$awards=$pdo->query("select * from award_numbers where 
year='$year' && period='$period'")->fetchALL();
//取完是空的>應該是資料庫無資料>去資料庫更新 UPDATE `award_numbers` SET `period`=6 WHERE year='2020' && period=1

echo "<pre>";
print_r($awards);
echo "</pre>";


?>