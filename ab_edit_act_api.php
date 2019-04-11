<?php
require __DIR__. '/__connect_db.php';

$result = [
    'success' => false, //資料修改是否成功
    'resultCode' => 400, //狀態碼
    'errorMsg' => '沒有 post 資料', //錯誤訊息
    'postData' => [],
];

if(!isset($_GET['sid'])){
    $result['resultCode'] = 401;
    $result['errorMsg'] = '沒有 sid';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
$sid =  intval($_GET['sid']);

if(!empty($_POST['name']) and !empty($_POST['email'])){
    $result['postData'] = $_POST;
    try {
        $sql = "UPDATE `address_book` SET 
            `name`=?,
            `email`=?,
            `mobile`=?,
            `address`=?,
            `birthday`=?
            WHERE `sid`=?";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['mobile'],
            $_POST['address'],
            $_POST['birthday'],
            $sid
        ]);

        $r = $stmt->rowCount();
        $result['rowCount'] = $r;
        if($r==1){
            $result['success'] = true;
            $result['resultCode'] = 200;
            $result['errorMsg'] = '';
        } elseif($result==0) {
            $result['resultCode'] = 403;
            $result['errorMsg'] = '資料沒有修改';
        }

    } catch(PDOException $ex){
        $result['resultCode'] = 405;
        $result['errorMsg'] = $ex->getMessage();

    }
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
