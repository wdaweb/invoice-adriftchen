<?php

include_once "base.php";

find('invoices',"id='9'");

//上面的指令丟到function裡會組成句子 select * from where id='9';
//$row=$pdo->query("select * from where id='9'")->fetch();
//$res=回傳的id為9的發票內容
//以上直接用pdo有錯誤訊息跑不出來:pdo沒定義
//funciton用pdo要設區域性global pdo

function find($table,$def){
  global $pdo;

  $sql="select * from $table where $def";
  $row=$pdo->query($sql)->fetch();

  return $row;
}

$row=find('invoices',"id='11'"); /*find()本身是一個變數, */
echo $row['code'];
echo $row['number'];

$row=find('invoices',"id='15'"); 
echo $row['code'];
echo $row['number'];



?>