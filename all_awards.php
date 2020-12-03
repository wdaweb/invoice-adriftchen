<!-- 一次對單期全部發票 -->
<!-- 在award_numbers.php按下全部對獎時如何知道去撈哪一期的發票?
  =>1.用GET帶 2.?do=all_awards後帶&year&period 
-->

<?php

include_once "base.php";
// 先include這樣下面的$pdo才能撈資料

$period_str=[
  1=>'1,2月',
  2=>'3,4月',
  3=>'5,6月',
  4=>'7,8月',
  5=>'9,10月',
  6=>'11,12月'
];

echo "目前對的是".$_GET['year']."年";
echo $period_str[$_GET['period']]."的發票";

//1.撈出該期發票
$sql="select * from invoices where period='{$_GET['period']}' && left(date,4)='{$_GET['year']}' order by date desc";
// echo $sql;
//php這裡無法用explode取得
// $year=explode("-",$_GET['pd'])[0];
// $period=explode("-",$_GET['pd'])[1];

// echo $sql;
$invoices=$pdo-> query($sql)->fetchALL(PDO::FETCH_ASSOC);
// echo count($invoices); /* 可看有幾筆 */
// print_r($invoices);

// echo "<pre>";
// print_r($invoices);
// echo "</pre>";

//2.撈出該期該獎獎號

$sql="select * from award_numbers where year='{$_GET['year']}' && period='{$_GET['period']}'";
$award_numbers=$pdo-> query($sql)->fetchALL(PDO::FETCH_ASSOC); /* 返回以欄位名稱作為索引鍵(key)的陣列(array) */
//PDO::FETCH_NUM 返回以數字作為索引鍵(key)的陣列(array)，由0開始編號
//PDO::FETCH_BOTH 返回 FETCH_ASSOC 和 FETCH_NUM 的結果，兩個都會列出

// echo "<pre>";
// echo count($award_umbers);
// echo "</pre>";

//3.開始對獎
//3-1.先套用單張對獎(in award.php)的方式，此時可先註解掉上方$award_numbers=$pdo->...因為foreach內已經撈過資料了
//結果會把中、不中全列出來->設全域變數讓中獎的號碼才列出來->先把號碼全對過，把$all_res=-1拿到迴圈外最後再判斷要顯示的資訊

$all_res=-1;
foreach($invoices as $inv){

    //對獎程式
    $number=$inv['number'];
    /* echo "<pre>";
    print_r($invoice);
    echo "</pre>"; */

    //找出獎號
    /**
     * 1.確認期數->目前的發票的日期做分析
     * 2.得到期數的資料後->撈出該期的開獎獎號
     * 
     */
    $date=$inv['date'];
    //explode('-',$date)取得日期資料的陣列,陣列的第二個元素就是月
    //月份就可以推算期數,有了期數及年份就可以找到開獎的號碼
    // $array=explode('-',$date)
    // $month=$array[1]
    // $period=ceil($month/2)
    $year=explode('-',$date)[0];
    $period=ceil(explode('-',$date)[1]/2);
    //echo "select * from award_numbers where year='$year' && period='$period'";
    //$awards=$pdo->query("select * from award_numbers where year='$year' && period='$period'")->fetchALL();

    /* 
    echo "<pre>";
    print_r($awards);
    echo "</pre>"; */



    foreach($award_numbers as $award){
        switch($award['type']){
            case 1:
                //特別號=我的發票號碼


                if($award['number']==$number){
                    echo "<br>號碼=".$number."<br>";
                    echo "<br>中了特別獎<br>";
                    $all_res=1;
                }
            break;
            case 2:

                if($award['number']==$number){
                    echo "<br>號碼=".$number."<br>";
                    echo "中了特獎<br>";
                    $all_res=1;
                }

            break;
            case 3:
                $res=-1;
                for($i=5;$i>=0;$i--){
                    $target=mb_substr($award['number'],$i,(8-$i),'utf8');
                    $mynumber=mb_substr($number,$i,(8-$i),'utf8');

                    if($target==$mynumber){

                        $res=$i;
                    }else{
                        break;
                        //continue
                    }
                }
                //判斷最後中的獎項
                if($res!=-1){
                    echo "<br>號碼=".$number."<br>";
                    echo "中了{$awardStr[$res]}獎<br>";
                    $all_res=1;
                }
            break;
            case 4:
                if($award['number']==mb_substr($number,5,3,'utf8')){
                    echo "<br>號碼=".$number."<br>";
                    $all_res=1;
                    echo "中了增開六獎";
                }
            break;
        }
    }



}
    if($all_res==-1){
        echo "很可惜，都沒有中";
    }

?>