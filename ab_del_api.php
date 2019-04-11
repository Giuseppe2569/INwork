<?php
require __DIR__. '/__connect_db.php';

$result = array(
    'success' => false,
    'resultCode' => 400,
    'errorMsg' => '沒有 claSid 參數',
    'rowCount' => 0,
);

if(!isset($_GET['claSid'])){
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
$claSid =  intval($_GET['claSid']);

$sql = "DELETE FROM `class` WHERE claSid=$claSid";

$stmt = $pdo->query($sql);

if($stmt->rowCount()==1){
    $result = array(
        'success' => true,
        'resultCode' => 200,
        'errorMsg' => '',
        'rowCount' => 1,
    );
} else {
    $result['resultCode'] = 402;
    $result['errorMsg'] = '資料沒有刪除';
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);

