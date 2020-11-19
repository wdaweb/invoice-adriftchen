<!-- 在award_numbers.php按下全部對獎時如何知道去撈哪一期的發票?
  =>1.用GET帶 2.?do=all_awards後帶&year&period 
-->

<?php

include_once "base.php";
// 先include這樣下面的$pdo才能撈資料

$period_str=[
  1=>'1,2月',
  1=>'3,4月',
  1=>'5,6月',
  1=>'7,8月',
  1=>'9,10月',
  1=>'11,12月'
];

echo "要對的發票為".$_GET['year']."年";
echo $period_str[$_GET['period']]."的發票";

//1.撈出該期發票
$sql="select * from invoices where period='{$_GET['period']}' && left(date,4)='{$_GET['year']}' order by date desc";

//php這裡無法用explode取得
// $year=explode("-",$_GET['pd'])[0];
// $period=explode("-",$_GET['pd'])[1];

echo $sql;
$invoices=$pdo-> query($sql)->fetchALL();
echo count($invoices); /* 可看有幾筆 */
print_r($invoices);

// echo "<pre>";
// print_r($invoices);
// echo "</pre>";

//2.撈出該期該獎獎號

$sql="select * from award_numbers where year='{$_GET['year']}' && period='{$_GET['period']}'";
$award_numbers=$pdo-> query($sql)->fetchALL(PDO::FETCH_ASSOC); /* 返回以欄位名稱作為索引鍵(key)的陣列(array) */
//PDO::FETCH_NUM 返回以數字作為索引鍵(key)的陣列(array)，由0開始編號
//PDO::FETCH_BOTH 返回 FETCH_ASSOC 和 FETCH_NUM 的結果，兩個都會列出

echo "<pre>";
echo count($award_umbers);
echo "</pre>";

//3.開始對獎




?>
單期全部對獎