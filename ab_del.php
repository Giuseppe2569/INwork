<?php
require __DIR__. '/__connect_db.php';

if(!isset($_GET['claSid'])){
    header('Location: ab_listClass.php');
    exit;
    //die('Hello');
}
$claSid =  intval($_GET['claSid']);

$sql = "DELETE FROM `class` WHERE claSid=$claSid";

$stmt = $pdo->query($sql);

//echo $stmt->rowCount();
if(isset($_SERVER['HTTP_REFERER'])){
    // 從哪裡來, 從哪裡回去
    header('Location: '. $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ab_listClass.php'); // 回到列表頁的第一頁
}



