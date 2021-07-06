<?php
//建假資料 rand()

include_once "base.php";

$codeBase=["AA","FF","GD","KJ","FJ","IY"];
echo "資料產生中...";
echo date("Y-m-d H:i:s");


for($i=0;$i<10000;$i++){

  $code=$codeBase[rand(0,5)];
  /*$number=rand(0,99999999);  只寫這樣若前面的位數有0，字串長度會減少而不是8個 */
  //另種寫法 echo str_pad($number,8,'0',STR_PAD_LEFT)."<br>";
  //echo $number."<br>";
  $number=sprintf("%08d",rand(0,99999999)); /* strlen=8且補位在前面 */
  $payment=rand(1,20000);
  // echo $payment;

  $start=strtotime("2020-01-01");
  $end=strtotime("2020-12-31");
  $date=date("Y-m-d",rand($start,$end));
  $period=ceil(explode("-",$date)[1]/2);
  // echo $date."<br>";


    $ga=[
    'code'=>$code,
    'number'=>$number,
    'payment'=>$payment,
    'date'=>$date,
    'period'=>$period
    ];

$sql="insert into invoices (`".implode("`,`",array_keys($ga))."`) values('".implode("','",$ga)."')";
echo $sql;
//insert 前為""指欄位名稱，value內為值放單引號''
$pdo->exec($sql);

}
echo "<hr>";
echo "資料新增至資料庫完成...";
echo date("Y-m-d H:i:s");
?>