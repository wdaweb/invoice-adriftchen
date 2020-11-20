<?php

include_once "base.php";


//上面的指令丟到function裡會組成句子 select * from where id='9';
//$row=$pdo->query("select * from where id='9'")->fetch();
//$res=回傳的id為9的發票內容
//以上直接用pdo有錯誤訊息跑不出來:pdo沒定義
//funciton用pdo要設區域性global pdo

function find($table,$id){
  global $pdo;

  if(is_numeric($id)){
    $sql="select * from $table where id='$id'";
  }else{
    $sql="select * from $table where $id";
  }

  $row=$pdo->query($sql)->fetch();

  return $row;
}

// function find2($table,$def){
//   global $pdo;

//   $sql="select * from $table where $def";
//   $row=$pdo->query($sql)->fetch();

//   return $row;
// }

$row=find('invoices',11); /*find()本身是一個變數, */
echo $row['code'].$row['number']."<br>";

$row=find('invoices',"code='AA'&& number='30292747'"); 
echo $row['code'].$row['number']."<br>";

$row=find('invoices',27); 
echo $row['code'].$row['number']."<br>";



?>