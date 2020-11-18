<?php
//單一發票對獎

include_once "base.php";

//最好檢查get是否有撈到資料，是否帶錯誤特殊符號
$inv_id=$_GET['id'];

//這裡出現fatal error
//把這行select丟回phpmyadmin看錯誤訊息
//必須在該行之前echo 才看的到
// echo "select * from invoices where id='$inv_id'";
$invoice=$pdo->query("select * from invoices where id='$inv_id'")->fetch();
$number=$invoice['number'];

//把資料庫叫出來的東西以陣列印出來看
// echo "<pre>";
// print_r($invoice);
// echo "</pre>";

//找出獎號
//1.確認期數->分析目前發票日期
//2.得到期數資料後->撈出該期的開獎號

$date=$invoice['date'];
//explode('-',$date)取得日期資料的陣列，陣列的第二個元素即月份->可推算期數、年份->可找開獎號
//$array=explode('-',$date)
//$month=$array[1]
//$period=ceil($month/2)

$year=explode('-',$date)[0];
$period=ceil((explode('-',$date)[1])/2);
//print_r($explode) 可看一下結果

// echo "select * from award_numbers where year='$year' && period='$period'";
$awards=$pdo->query("select * from award_numbers where 
year='$year' && period='$period'")->fetchALL();
//取完是空的>應該是資料庫無資料>去資料庫更新 UPDATE `award_numbers` SET `period`=6 WHERE year='2020' && period=1

echo "<pre>";
print_r($awards);
echo "</pre>";

//單筆對獎
//$award為陣列型態，$award['type']才是數字，$number可能為字串
//只寫if($award==$number)兩個資料比對，就算從phpmyadmin改為中獎號碼也會顯示不中=>因為沒有從資料型態比對，瀏覽器也不會有錯誤訊息

//先設$all_res==-1，若$res=$i=>有中(任何一個獎)=>$all_res值改變=>最後特別顯示;若無(值不變)=>最後顯示"未中任何獎"

$all_res=-1;
foreach($awards as $award){
    switch($award['type']){
        case 1:
            //特別獎=我的發票號碼
            if($award['number']==$number){
                echo "<br>號碼=".$number."<br>";
                echo "<br>中了特別獎<br>";
            }else{
                echo "<br>特別獎沒中<br>";
                $all_res=1; /* 可設-1以外的值 */
            }
        break;
        case 2:
            //特獎
            if($award['number']==$number){
                echo "<br>號碼=".$number."<br>";
                echo "中了特獎<br>";
            }else{
                echo "特獎沒中<br>";
                $all_res=1;
            }

        break;
        case 3:
            //頭獎、二獎~六獎，除了頭獎，之後獎從六獎開始往前對
            //$res變動表示有中二到六某個特定獎，解決重複中五/四/三..的問題
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
            //以下echo要讓$res迴圈跑完，放在最外面，不要一個一個顯示出來(三/四獎沒中...)
            if($res!=-1){
                echo "<br>號碼=".$number."<br>";
                echo "中了{$awardStr[$res]}獎<br>";
                $all_res=1;
            }
        break;
        case 4:
            //mb_substr($number,5,3)為key值第5位之後取3碼(5-7)
            if($award['number']==mb_substr($number,5,3,'utf8')){
                echo "<br>號碼=".$number."<br>";
                $all_res=1;
                echo "中了增開六獎";
            }
        break;
    }
}

if($all_res==-1){
    echo "本次未中任何獎";
}

?>