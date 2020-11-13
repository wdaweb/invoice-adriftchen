<?php
include_once "base.php";

$sql="select * from `invoices` order by date";

$rows=$pdo->query($sql)->fetchAll();

//測試用可刪掉了
// foreach($rows as $row){
//     echo $row['code'].$row['number']."<br>";
// }

?>

<table class="table text-center">
    <tr>
        <td>發票號碼</td>
        <td>消費日期</td>
        <td>消費金額</td>
        <td>操作</td>
    </tr>

<?php
foreach($rows as $row){
?>
<tr>
    <td><?=$row['code'].$row['number']?></td>
    <td><?=$row['date']?></td>
    <td><?=$row['payment']?></td>
    <td>
    <button class="btn btn-sm btn-primary">
        <a class="text-light" href="?do=edit_invoice&id=<?=$row['id'];?>">編輯</a>
        </button>
    <button class="btn btn-sm btn-danger">
    <a class="text-light" href="?do=del_invoice&id=<?=$row['id'];?>">刪除
    </button>
    </td>
</tr>
<?php
}
?>
</table>