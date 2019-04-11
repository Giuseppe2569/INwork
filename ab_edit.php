<?php
require __DIR__. '/__connect_db.php';

$pname = 'edit'; // 自訂的頁面名稱

if(!isset($_GET['claSid'])){
    header('Location: ab_listClass.php');
    exit;
}
$claSid =  intval($_GET['claSid']);

if(!empty($_POST['claName']) and !empty($_POST['claSport'])){

    try {
        $sql = "UPDATE `class` SET 
        `claName`=?,
        `claSport`=?,
        `claTimeUp`=?,
        `claTimeEnd`=?,
        `claGender`=?,
        `claCost`=?,
        `claCutoff`=?,
        `claPleNum`=?,
        `claCity`=?,
        `claArea`=?,
        `claAddress`=?,
        `plaName`=?
        WHERE `claSid`=? ";


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
$r_sql = "SELECT * FROM class WHERE claSid=$claSid";
$r_row = $pdo->query($r_sql)->fetch(PDO::FETCH_ASSOC);

if(empty($r_row)){
    // 如果沒有該筆資料,就到列表頁
    header('Location: ab_listClass_api.php');
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
                        <label for="claName">課程名稱</label>
                        <input type="text" class="form-control"
                               id="claName" name="claName" value="<?= htmlentities($r_row['claName']) ?>"
                               placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="claSport">運動品項</label>
                        <input type="claSport" class="form-control"
                               id="claSport" name="claSport" value="<?= htmlentities($r_row['claSport']) ?>"
                               placeholder="Enter claSport">
                    </div>
                    <div class="form-group">
                        <label for="claTimeUp">開始時間</label>
                        <input type="datetime-local" class="form-control"
                               id="claTimeUp" name="claTimeUp" value="<?= htmlentities($r_row['claTimeUp']) ?>"
                               placeholder="YYYY-MM-DD">
                    </div>
                    <div class="form-group">
                        <label for="claTimeEnd">結束時間</label>
                        <input type="datetime-local" class="form-control"
                               id="claTimeEnd" name="claTimeEnd" value="<?= htmlentities($r_row['claTimeEnd']) ?>"
                               placeholder="YYYY-MM-DD">
                    </div>
                    <div class="form-group">
                        <label for="claGender">性別限制</label>
                        <input type="text" class="form-control"
                               id="claGender" name="claGender" value="<?= htmlentities($r_row['claGender']) ?>"
                               placeholder="Enter claGender">
                    </div>
                    <div class="form-group">
                        <label for="claCost">費用</label>
                        <input type="text" class="form-control"
                               id="claCost" name="claCost" value="<?= htmlentities($r_row['claCost']) ?>"
                               placeholder="Enter claCost">
                    </div>
                    <div class="form-group">
                        <label for="claCutoff">報名截止時間</label>
                        <input type="datetime-local" class="form-control"
                               id="claCutoff" name="claCutoff" value="<?= htmlentities($r_row['claCutoff']) ?>"
                               placeholder="Enter YYYY-MM-DD">
                    </div>
                    <div class="form-group">
                        <label for="claPleNum">人數上限</label>
                        <input type="text" class="form-control"
                               id="claPleNum" name="claPleNum" value="<?= htmlentities($r_row['claPleNum']) ?>"
                               placeholder="Enter claPleNum">
                    </div>
                    <div class="form-group">
                        <label for="claCity">城市</label>
                        <input type="text" class="form-control"
                               id="claCity" name="claCity" value="<?= htmlentities($r_row['claCity']) ?>"
                               placeholder="Enter claCity">
                    </div>
                    <div class="form-group">
                        <label for="claArea">區域</label>
                        <input type="text" class="form-control"
                               id="claArea" name="claArea" value="<?= htmlentities($r_row['claArea']) ?>"
                               placeholder="Enter claArea">
                    </div>
                    <div class="form-group">
                        <label for="claAddress">地址</label>
                        <input type="text" class="form-control"
                               id="claAddress" name="claAddress" value="<?= htmlentities($r_row['claAddress']) ?>"
                               placeholder="Enter claAddress">
                    </div>
                    <div class="form-group">
                        <label for="plaName">地點</label>
                        <input type="text" class="form-control"
                               id="plaName" name="plaName" value="<?= htmlentities($r_row['plaName']) ?>"
                               placeholder="Enter plaName">
                    </div>
                    <button type="submit" class="btn btn-primary">修改</button>
                </form>

            </div>
        </div>
    </div>
</div>
    <script>
        // var name = $('#claName'),
        //     sport = $('#claSport'),
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