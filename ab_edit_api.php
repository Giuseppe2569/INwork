<?php
require __DIR__. '/__connect_db.php';

$result = [
    'success' => false, //資料修改是否成功
    'resultCode' => 400, //狀態碼
    'errorMsg' => '沒有 post 資料', //錯誤訊息
    'postData' => [],
];

if(!isset($_GET['claSid'])){
    $result['resultCode'] = 401;
    $result['errorMsg'] = '沒有 claSid';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
$claSid =  intval($_GET['claSid']);

if(!empty($_POST['claName']) and !empty($_POST['claSport'])){
    $result['postData'] = $_POST;
    try {
        $sql = "UPDATE `address_book` SET 
            `claName`=?,
            `claSport`=?,
            `claTimeUp`=?,
            `claTimeEnd`=?,
            `claGender`=?
            `claCost`=?
            `claCutoff`=?
            `claPleNum`=?
            `claCity`=?
            `claArea`=?
            `claAddress`=?
            `plaName`=?
            WHERE `claSid`=?";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_POST['claName'],
            $_POST['claSport'],
            $_POST['claTimeUp'],
            $_POST['claTimeEnd'],
            $_POST['claGender'],
            $_POST['claCost'],
            $_POST['claCutoff'],
            $_POST['claPleNum'],
            $_POST['claCity'],
            $_POST['claArea'],
            $_POST['claAddress'],
            $_POST['plaName'],
            $claSid
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
