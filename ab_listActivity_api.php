<?php
require __DIR__. '/__connect_db.php';

$per_page = 5; //每頁有幾筆

$result = [
    'success' => false, //資料取得是否成功
    'resultCode' => 400, //狀態碼
    'errorMsg' => '', //錯誤訊息
    'perPage' => $per_page, //每頁有 5 筆
    'data' => [], //項目資料
];


$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // 第幾頁

$t_sql = "SELECT COUNT(1) FROM active";
$total_rows = $pdo->query($t_sql)->fetch()[0]; //總筆數
$total_pages = ceil($total_rows/$per_page); //總頁數

$result['totalRows'] = $total_rows;
$result['totalPages'] = $total_pages;

// 限定頁碼範圍
if($page<1){
    $result['resultCode'] = 402;
    $result['errorMsg'] = '頁碼值小於一';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
if($page>$total_pages) {
    $result['resultCode'] = 403;
    $result['errorMsg'] = '頁碼值大於總頁數';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
$result['page'] = $page;  //第幾頁

$sql = sprintf("SELECT * FROM active ORDER BY sid DESC LIMIT %s, %s",
    ($page-1)*$per_page, $per_page);

// 取得該頁的項目資料
$result['data'] = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$result['success'] = true;
$result['resultCode'] = 200;

echo json_encode($result, JSON_UNESCAPED_UNICODE);