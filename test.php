<?php

include_once "base.php";



//"select * from invoices where id='9'";
//$row=$pdo->query("select * from invoices where id='9'")->fetch();
//$res=回傳的id為9的發票內容
echo implode(" && ",['欄位1'=>'值1','欄位2'=>'值2','id'=>'9']);
echo "<br>";
echo "欄位1='值1' && 欄位2='值2' && id='9'";
echo "<hr>";
$array=['欄位1'=>'值1','欄位2'=>'值2','id'=>'9'];
echo "<hr>";

//利用一個暫時的陣列來存放語句的片段
foreach($array as $key => $value){
    $tmp[]=sprintf("`%s`='%s'",$key,$value);
    //$tmp[]="`".$key."`='".$value."'";
}

print_r($tmp);
echo "<br>";

//使用implode把暫時陣列中的語句串回SQL語法
echo implode(" && ",$tmp);

echo "<br>";
function find($table,$id){
    global $pdo;
    $sql="select * from $table where "; //把重複的句子拉到前面
    if(is_array($id)){
        foreach($id as $key => $value){
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
            //$tmp[]="`".$key."`='".$value."'";
        }
        $sql=$sql.implode(' && ',$tmp);
    }else{
        $sql=$sql . " id='$id' ";
    }
    $row=$pdo->query($sql)->fetch();

    return $row;
}

$row=find('invoices',5);
echo $row['code'].$row['number']."<br>";

$row=find('invoices',['code'=>'KJ','number'=>'69954161']);
echo $row['code'].$row['number']."<br>";

$row=find('invoices',17);
echo $row['code'].$row['number']."<br>";


?>