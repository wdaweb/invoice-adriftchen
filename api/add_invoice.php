<?php
//撰寫新增消費發票的程式碼
//將發票的號碼及相關資訊寫入資料庫

// foreach($_POST as $key => $value){
//     echo "欄位".$key."==值" .$value."<br>";把此行換成下面方式:將變數輸出結果再丟入
//     $tmp[]=$key;
//   }

include_once "../base.php";

$_SESSION['err']=[];


echo "<pre>";
print_r(array_keys($_POST));
echo "</pre>";

accept('number','發票號碼欄未必填');

// $sql="insert into invoices (`".implode("`,`",array_keys($_POST))."`) values('".implode("','",$_POST)."')";
//insert 前為""指欄位名稱，value內為值放單引號''
// echo $sql;

// 以下導入函式直接用，可把#21、#23註解掉
save('invoices',$_POST);


echo "新增完成";

if(empty($_SESSION['err'])){
  $pdo->exec($sql); //確認格式無誤才新增到資料庫
  header("location:../index.php?do=invoice_list");
}else{
  header("location:../index.php");
}


?>