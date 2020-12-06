<?php
include_once "../base.php";

// $pdo->exec("delete from invoices where id='{$_GET['id']}'");
// 以上註解掉，導入函式直接用
del('invoices',$_GET['id']);

header("location:../index.php?do=invoice_list&start=1");

?>