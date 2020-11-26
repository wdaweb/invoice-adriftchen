<?php

include_once "base.php";

//取得單一資料的自訂函式
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
    $row=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC); /* (PDO::FETCH_ASSOC)只撈出欄位 不含索引值 */

    // 原寫法 mysqli_fetch_assoc() 有索引 有欄位

    return $row;
}

function all($table,...$arg){
  global $pdo;

//   echo gettype($arg);

  $sql="select * from $table "; 

  if(isset($arg[0])){
    if(is_array($arg[0])){
        //製作會在 where 後面的句子字串(陣列格式)
        if(!empty($arg[0])){
            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
                //$tmp[]="`".$key."`='".$value."'";
            }

            $sql=$sql." where ".implode(' && ',$tmp);
        }

    }else{
        //製作非陣列的語句接在$sql後面
            $sql=$sql.$arg[0];       
    }
}

if(isset($arg[1])){

    $sql=$sql.$arg[1];

}
echo $sql."<br>";
return $pdo->query($sql)->fetchAll(); 

}

//到資料庫刪資料的func.
function del($table,$id){
    global $pdo;
    $sql="delete from $table where "; //把重複的句子拉到前面

    if(is_array($id)){
        foreach($id as $key => $value){
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
            //$tmp[]="`".$key."`='".$value."'";
        }
        $sql=$sql.implode(' && ',$tmp);
    }else{
        $sql=$sql . " id='$id' ";
    }
    // echo $sql;
    $row=$pdo->exec($sql);

    return $row;
}


//更新一筆的方法 多筆要另外寫
function update($table,$array){
    global $pdo;
    $sql="update $table set ";
    foreach($array as $key => $value){
        if($key!= 'id'){
            
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
    }
    $sql=$sql.implode(",",$tmp) . " where `id`='{$array['id']}'";
    echo $sql;
    $pdo->exec($sql);
}
function insert($table,$array){
    global $pdo;
    $sql="insert into $table(`" . implode("`,`",array_keys($array)) . "`) values('".implode("','",$array)."')";
    $pdo->exec($sql);   
}

function save($table,$array){ /* 用save 資料必須是陣列 */
    if(isset($array['id'])){
        update($table,$array);  /* 有帶id才新增、儲存 */
    }else{
        insert($table,$array);
    }
}

//沒有funciton前的寫法，要把sql語句寫出來
// $row=find('invoices',22);
// echo "<pre>";
// print_r($row);
// echo "</pre><br>";
// update invoices set `code`='AA',`payment`='1' where `id`='22';
// $row['code']='AA';
// $row['payment']='1';

// update('invoices',$row);


// $def=['id'=>25];
// echo del('invoices', $def);
// print_r(all('invoices',['id'=>20])[0]);
// print_r(all('invoices',['code'=>'AB']));

// echo "<hr>";
// print_r(all('invoices'));
// echo "<hr>";
// print_r(all('invoices',['code'=>"AB",'period'=>6]));
// echo "<hr>";
// print_r(all('invoices',['code'=>"AB",'period'=>1])," order by date ");
// echo "<hr>";
// print_r(all('invoices'));

//四種all()取得多筆資料的方法
echo "<hr>";
all('invoices');
echo "<hr>";
all('invoices',['code'=>"AB",'period'=>6]);
echo "<hr>";
all('invoices',['code'=>"AB",'period'=>1]," order by date ");
echo "<hr>";
all('invoices',"limit 5");

?>