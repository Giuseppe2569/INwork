<?php
require __DIR__. '/__connect_db.php';

$pname = 'addPro'; // 自訂的頁面名稱

if(!empty($_POST['proName']) and !empty($_POST['proNum'])){

//    $sql = sprintf("INSERT INTO `?products`(
// `name`, `email`, `mobile`, `address`, `birthday`, `created_at`
// ) VALUES (%s, %s, %s, %s, %s, NOW())",
//        $pdo->quote($_POST['name']),
//        $pdo->quote($_POST['email']),
//        $pdo->quote($_POST['mobile']),
//        $pdo->quote($_POST['address']),
//        $pdo->quote($_POST['birthday'])
//
//        );
//
//    echo $sql;



        $sql = "INSERT INTO `products`(
        `proName`,
        `proNum`, 
        `proInfo`, 
        `proColor`, 
       
        `proOPrice`, 
        `proPrice`, 
        `proSpec`, 
        -- `proFormat`, 
        `proTag`, 
        `proType`, 
        -- `proImg`, 
        `proCreate`, 
        `proActive`, 
        `proStorage`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_POST['proName'], //商品名稱
            $_POST['proNum'],  //商品編號
            $_POST['proInfo'], //介紹
            $_POST['proColor'],//顏色
            $_POST['proOPrice'],//原價
            $_POST['proPrice'],//特價
            $_POST['proSpec'], //特色
            $_POST['proTag'],  //Tag
            $_POST['proType'], //類型
            // $_POST['proImg'],
            $_POST['proCreate'], //產地
            $_POST['proActive'], //Active
            $_POST['proStorage'] //庫存
        ]);

        $result = $stmt->rowCount();
        if($result==1){
            $info = [
                'type' => 'success',
                'text' => '資料新增完成'
            ];
        } elseif($result==0) {
            $info = [
                'type' => 'danger',
                'text' => '資料沒有新增'
            ];
        }


    
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
                <h5 class="card-title">新增商品 <?php isset($result)? var_dump($result) : '' ?></h5>
                <form method="post" >
                    <div class="form-group">
                        <label for="proName">商品名稱</label>
                        <input type="text" class="form-control"
                               id="proName" name="proName" placeholder="Enter 商品">  
                    </div>
                    <div class="form-group">
                        <label for="proNum">商品編號</label>
                        <input type="proNum" class="form-control"
                               id="proNum" name="proNum" placeholder="Enter 編號">
                    </div>
                    <div class="form-group">
                        <label for="proInfo">介紹</label>
                        <input type="text" class="form-control"
                               id="proInfo" name="proInfo" placeholder="Enter 介紹">
                    </div>
                    <div class="form-group">
                        <label for="proColor">顏色</label>
                        <input type="text" class="form-control"
                               id="proColor" name="proColor" placeholder="Enter 顏色">
                    </div>
                    <div class="form-group">
                        <label for="proOPrice">原價</label>
                        <input type="text" class="form-control"
                               id="proOPrice" name="proOPrice" placeholder="Enter 原價">
                    </div>
                    <div class="form-group">
                        <label for="proPrice">特價</label>
                        <input type="text" class="form-control"
                               id="proPrice" name="proPrice" placeholder="Enter 特價">
                    </div>
                    <div class="form-group">
                        <label for="proSpec">特色</label>
                        <input type="text" class="form-control"
                               id="proSpec" name="proSpec" placeholder="Enter 特色">
                    </div>
                    <div class="form-group">
                        <label for="proTag">Tag</label>
                        <input type="text" class="form-control"
                               id="proTag" name="proTag" placeholder="Enter 標籤">
                    </div>
                    <div class="form-group">
                        <label for="proType">類型</label>
                        <input type="text" class="form-control"
                               id="proType" name="proType" placeholder="Enter 類型">
                    </div>
                    <!-- <div class="form-group">
                        <label for="proImg">圖片</label>
                        <input type="text" class="form-control"
                               id="proImg" name="proImg" placeholder="Enter 圖片">
                    </div> -->
                    <div class="form-group">
                        <label for="proCreate">產地</label>
                        <input type="text" class="form-control"
                               id="proCreate" name="proCreate" placeholder="Enter 產地">
                    </div>
                    <div class="form-group">
                        <label for="proActive">Active</label>
                        <input type="text" class="form-control"
                               id="proActive" name="proActive" placeholder="Enter Active">
                    </div>
                    <div class="form-group">
                        <label for="proStorage">庫存</label>
                        <input type="text" class="form-control"
                               id="proStorage" name="proStorage" placeholder="Enter 庫存">
                    </div>
                    <button type="submit" class="btn btn-primary">上架</button>
                </form>

            </div>
        </div>
    </div>
</div>
    <script>
         var form_els = document.forms[0];
         var el, i;

         // 用迴圈取得表單裡的每一個元素
         // for(i=0; i<form_els.length; i++){
         //     el = $(form_els[i]);
         //     console.log(i, el);
         //     console.log(el.attr('name'), el.val());
         // }

         for(i=0; i<form_els.length; i++){
             el = form_els[i];
             console.log(i, el);
             console.log(el.name, el.value);
         }

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