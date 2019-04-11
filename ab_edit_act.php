<?php
require __DIR__. '/__connect_db.php';

$pname = 'edit'; // 自訂的頁面名稱

if(!isset($_GET['actSid'])){
    header('Location: ab_listActivity.php');
    exit;
}
$actSid =  intval($_GET['actSid']);

if(!empty($_POST['actName']) and !empty($_POST['actSport'])){
    try {
        $sql = "UPDATE `active` SET 
        `actName`=?,
        `actSport`=?,
        `actTimeUp`=?,
        `actTimeEnd`=?,
        `actGender`=?,
        -- `actCost`=?,
        `actCutoff`=?,
        `actPleNum`=?,
        `actCity`=?,
        `actArea`=?,
        `actAddress`=?,
        `plaName`=?
        WHERE `actSid`=?";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_POST['actName'],
            $_POST['actSport'],
            $_POST['actTimeUp'],
            $_POST['actTimeEnd'],
            $_POST['actGender'],
            // $_POST['actCost'],
            $_POST['actCutoff'],
            $_POST['actPleNum'],
            $_POST['actCity'],
            $_POST['actArea'],
            $_POST['actAddress'],
            $_POST['plaName'],
            $actSid
        ]);

        $result = $stmt->rowCount();
        if($result==1){
            $info = [
                'type' => 'success',
                'text' => '資料修改成功'
            ];
        } elseif($result==0) {
            $info = [
                'type' => 'danger',
                'text' => '資料修改失敗'
            ];
        }

    } catch(PDOException $ex){
        echo $ex->getMessage();
        //echo '---'. $ex->getCode(). '---';
//        $info = [
//            'type' => 'danger',
//            'text' => 'email 請勿重複'
//        ];
    }
}

// 讀取修改後的資料
$r_sql = "SELECT * FROM active WHERE actSid=$actSid";
$r_row = $pdo->query($r_sql)->fetch(PDO::FETCH_ASSOC);

if(empty($r_row)){
    // 如果沒有該筆資料,就到列表頁
    header('Location: ab_listActivity.php');
    exit;
}

?>
<?php include __DIR__. '/__html_head.php'; ?>
<?php include __DIR__. '/__navbar.php'; ?>
<div class="container" style="margin-top: 20px">
    <?php if(isset($info)): ?>
    <div class="col-md-6">
        <div class="alert alert-<?= $info['type'] ?>" role="alert">
            <?= $info['text'] ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">修改資料</h5>
                <form method="post" >
                <div class="form-group">
                        <label for="actName">活動名稱</label>
                        <input type="text" class="form-control"
                               id="actName" name="actName" value="<?= htmlentities($r_row['actName']) ?>"
                               placeholder="Enter 名稱">
                    </div>
                    <div class="form-group">
                        <label for="actSport">運動品項</label>
                        <input type="actSport" class="form-control"
                               id="actSport" name="actSport" value="<?= htmlentities($r_row['actSport']) ?>"
                               placeholder="Enter 運動">
                    </div>
                    <div class="form-group">
                        <label for="actTimeUp">開始時間</label>
                        <input type="datetime-local" class="form-control"
                               id="actTimeUp" name="actTimeUp" value="<?= htmlentities($r_row['actTimeUp']) ?>"
                               placeholder="YYYY-MM-DD">
                    </div>
                    <div class="form-group">
                        <label for="actTimeEnd">結束時間</label>
                        <input type="datetime-local" class="form-control"
                               id="actTimeEnd" name="actTimeEnd" value="<?= htmlentities($r_row['actTimeEnd']) ?>"
                               placeholder="YYYY-MM-DD">
                    </div>
                    <div class="form-group">
                        <label for="actGender">性別限制</label>
                        <input type="text" class="form-control"
                               id="actGender" name="actGender" value="<?= htmlentities($r_row['actGender']) ?>"
                               placeholder="Enter 性別限制">
                    </div>
                    <!-- <div class="form-group">
                        <label for="claCost">費用</label>
                        <input type="text" class="form-control"
                               id="claCost" name="claCost" value="<?= htmlentities($r_row['claCost']) ?>"
                               placeholder="Enter claCost">
                    </div> -->
                    <div class="form-group">
                        <label for="actCutoff">報名截止時間</label>
                        <input type="datetime-local" class="form-control"
                               id="actCutoff" name="actCutoff" value="<?= htmlentities($r_row['actCutoff']) ?>"
                               placeholder="Enter YYYY-MM-DD">
                    </div>
                    <div class="form-group">
                        <label for="actPleNum">人數上限</label>
                        <input type="text" class="form-control"
                               id="actPleNum" name="actPleNum" value="<?= htmlentities($r_row['actPleNum']) ?>"
                               placeholder="Enter 人數上限">
                    </div>
                    <div class="form-group">
                        <label for="actCity">城市</label>
                        <input type="text" class="form-control"
                               id="actCity" name="actCity" value="<?= htmlentities($r_row['actCity']) ?>"
                               placeholder="Enter 城市">
                    </div>
                    <div class="form-group">
                        <label for="actArea">區域</label>
                        <input type="text" class="form-control"
                               id="actArea" name="actArea" value="<?= htmlentities($r_row['actArea']) ?>"
                               placeholder="Enter 區域">
                    </div>
                    <div class="form-group">
                        <label for="actAddress">地址</label>
                        <input type="text" class="form-control"
                               id="actAddress" name="actAddress" value="<?= htmlentities($r_row['actAddress']) ?>"
                               placeholder="Enter 地址">
                    </div>
                    <div class="form-group">
                        <label for="plaName">地點</label>
                        <input type="text" class="form-control"
                               id="plaName" name="plaName" value="<?= htmlentities($r_row['plaName']) ?>"
                               placeholder="Enter 地點">
                    </div>
                    <button type="submit" class="btn btn-primary">修改</button>
                </form>

            </div>
        </div>
    </div>
</div>
    <script>
        // var name = $('#name'),
        //     email = $('#email'),
        //     i;

        // function formCheck(){
        //     var birthday_pattern = /\d{4}\-\d{1,2}\-\d{1,2}/;
        //     var isPass = true;

        //     if(! name.val()){
        //         alert('請填寫姓名');
        //         isPass = false;
        //     }
        //     if(! email.val()){
        //         alert('請填寫電子郵箱');
        //         isPass = false;
        //     }
        //     return isPass;
        // }

    </script>
<?php include __DIR__. '/__html_foot.php';