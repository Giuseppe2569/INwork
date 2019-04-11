<?php
require __DIR__. '/__connect_db.php';

$result = [
    'success' => false, //資料取得是否成功
    'resultCode' => 400, //狀態碼
    'errorMsg' => '沒有 post 資料', //錯誤訊息
    'postData' => [],
];

if(!empty($_POST['name']) and !empty($_POST['email'])){

    $r_sql = "SELECT * FROM address_book WHERE email=?";
    $r_stmt = $pdo->prepare($r_sql);
    $r_stmt->execute([
        $_POST['email']
    ]);
    if($r_stmt->rowCount()==1){
        $result['resultCode'] = 408;
        $result['errorMsg'] = 'email 重複';
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    $result['postData'] = $_POST;

    try {

        $sql = "INSERT INTO `address_book`(`name`, `email`, `mobile`, `address`, `birthday`, `created_at`) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['mobile'],
            $_POST['address'],
            $_POST['birthday']
        ]);

        $r = $stmt->rowCount();
        $result['rowCount'] = $r;

        if($r==1){
            $result['success'] = true;
            $result['resultCode'] = 200;
            $result['errorMsg'] = '';

        } elseif($r==0) {
            $result['resultCode'] = 405;
            $result['errorMsg'] = '資料沒有新增';
        }
    } catch(PDOException $ex){
        $result['resultCode'] = 407;
        $result['errorMsg'] = $ex->getMessage();
    }
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
