<?php
include_once "../base.php";

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

// $sql="update invoices 
//   set 
//     `code`='{$_POST['code']}',
//     `number`='{$_POST['number']}',
//     `date`='{$_POST['date']}',
//     `payment`='{$_POST['payment']}' 
//   where 
//     `id`='{$_POST['id']}'";

// 以上註解掉，改導入函式直接用

$row=find('invoices',$_POST['id']); /* 先去撈資料 */

$row['code']=$_POST['code'];  /* 收到變更 */
$row['number']=$_POST['number'];
$row['date']=$_POST['date'];
$row['payment']=$_POST['payment'];
//$row['id']=$_POST['id'];

save('invoices',$row); /* 存入資料庫*/
//$pdo->exec($sql);

to("../index.php?do=invoice_list&start=1") /* 這裡也改用函式，不用header */
//header("location:../index.php?do=invoice_list");


?>
