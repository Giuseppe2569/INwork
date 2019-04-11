<?php
require __DIR__. '/__connect_db.php';

$pname = 'changePro'; // 自訂的頁面名稱


// TODO: is admin


if(!isset($_GET['proSid'])){
    header('Location: ab_products.php');
    exit;
}
$proSid =  intval($_GET['proSid']);


$sql = "SELECT `proActive` FROM `products` WHERE `proSid`=$proSid";

$proActive = $pdo->query($sql)->fetch(PDO::FETCH_NUM)[0];



if($proActive==1){
    $newVal = 0;
} else {
    $newVal = 1;
}


$sql = "UPDATE `products` SET `proActive`=? WHERE `proSid`=?";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    $newVal,
    $proSid
]);

if($newVal==0){
    echo "下架";
} else {
    echo "上架";
}




