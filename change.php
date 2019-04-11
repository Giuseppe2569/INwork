<?php
require __DIR__. '/__connect_db.php';

$pname = 'change'; // 自訂的頁面名稱


// TODO: is admin


if(!isset($_GET['memSid'])){
    header('Location: ab_member.php');
    exit;
}
$memSid =  intval($_GET['memSid']);


$sql = "SELECT `memActive` FROM `members` WHERE `memSid`=$memSid";

$memActive = $pdo->query($sql)->fetch(PDO::FETCH_NUM)[0];



if($memActive==1){
    $newVal = 2;
} else {
    $newVal = 1;
}


$sql = "UPDATE `members` SET `memActive`=? WHERE `memSid`=?";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    $newVal,
    $memSid
]);

if($newVal==1){
    echo "一般會員";
} else {
    echo "教練";
}



