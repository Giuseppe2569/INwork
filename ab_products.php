<?php

require __DIR__. '/__connect_db.php';
$pname = 'products'; // 自訂的頁面名稱

$per_page = 10; //每頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // 第幾頁

$t_sql = "SELECT COUNT(1) FROM products";
$total_rows = $pdo->query($t_sql)->fetch()[0]; //總筆數
$total_pages = ceil($total_rows/$per_page); //總頁數

// 限定頁碼範圍
if($page<1){
    header('Location: ab_products.php');
    exit;
}
if($page>$total_pages){
    header('Location: ab_products.php?page='. $total_pages);
    exit;
} 

$sql = sprintf("SELECT
                proSid,
                proName,
                proNum,
                proInfo,
                proColor,
                proOPrice,
                proPrice,
                proSpec,
                proFormat,
                proType,
                proImg,
                proCreate,
                proActive,
                proStorage,
                (SELECT levName FROM levpro WHERE levSid = products.proActive ) as 'levName'
                FROM products ORDER BY proSid DESC LIMIT %s, %s",($page-1)*$per_page, $per_page);
                $stmt = $pdo->query($sql);

?>

<style>
    .ge-classImg {
        width: 100px;
         
        
    }
    .coaImg{
        width: 100%;
        object-fit: cover;
    }
    /* .g_infoText{
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 50px;
    } */
}
</style>

<?php include __DIR__. '/__html_head.php'; ?>
<?php include __DIR__. '/__navbar.php'; ?>

<div class="container" style="margin-top: 20px">

    <nav aria-label="Page navigation example">
        <ul class="pagination">
<!--            <li class="page-item"><a class="page-link" href="#">Previous</a></li>-->

            <?php for($i=1; $i<=$total_pages; $i++):?>
            <li class="page-item <?= $i==$page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
            </li>
            <?php endfor ?>

<!--            <li class="page-item"><a class="page-link" href="#">Next</a></li>-->
        </ul>
    </nav>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th scope="col">修改</th>
            <th scope="col">#</th>
            
            <th scope="col">狀態</th>
            <th scope="col">狀態修改</th>

            <th scope="col">商品名稱</th>
            <th scope="col">商品編號</th>
            <th scope="col">介紹</th>
            <th scope="col">顏色</th>
            <th scope="col">原價</th>
            <th scope="col">特價</th>
            <th scope="col">特色</th>
            <th scope="col">類型</th>
            <th scope="col">圖片</th>
            <th scope="col">產地</th>
            
            <th scope="col">庫存</th>
            
            <th scope="col">del</th>
        </tr>
        </thead>
        <tbody>
        <?php while($r = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr id="row<?= $r['proSid'] ?>">         
            <td><a href="ab_edit.php?proSid=<?= $r['proSid'] ?>"><i class="fas fa-edit"></i></a></td>
            <td scope="row"><?= $r['proSid'] ?></td>

            <td><?= $r['levName'] ?></td>
            <td><a href="javascript:change_active(<?= $r['proSid'] ?>)"><i class="fas fa-edit"></i></a></td>

            <td><span class="JQellipsis"><?= $r['proName'] ?></span></td>
            <td><?= $r['proNum'] ?></td>
            <td><span class="JQellipsis"><?= $r['proInfo'] ?></span></td>
            <td><?= $r['proColor'] ?></td>
            <td><?= $r['proOPrice'] ?></td>
            <td><?= $r['proPrice'] ?></td>
            <td><span class="JQellipsis"><?= $r['proSpec'] ?></span></td>
            <!-- title= -->
            <td><?= $r['proType'] ?></td>

            <td class="ge-classImg"><img class="coaImg" src="http://localhost:3000/images/products/<?= $r['proName']?>.jpg" alt="Card image cap">

            <td><?= $r['proCreate'] ?></td>
            
            <td><?= $r['proStorage'] ?></td>
            
            <td><a href="javascript:del_it(<?= $r['proSid'] ?>)"><i class="fas fa-trash-alt"></i></a></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $page==1 ? 'disabled' : ''; ?>"><a class="page-link" href="?page=1">&lt;&lt;</a></li>
            <li class="page-item <?= $page==1 ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?= $page-1 ?>">&lt;</a></li>
            <li class="page-item"><a class="page-link"><?= $page. '/'. $total_pages ?></a></li>
            <li class="page-item <?= $page==$total_pages ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?= $page+1 ?>">&gt;</a></li>
            <li class="page-item <?= $page==$total_pages ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?= $total_pages ?>">&gt;&gt;</a></li>
        </ul>
    </nav>
</div>
<script>
        function del_it(proSid){
            if(confirm('你確定要刪除編號為 '+proSid+' 的資料嗎?')){
                location.href = 'ab_del.php?proSid=' + proSid;
            }
        }
        
        function change_active(proSid){
           
           $.get('changePro.php?proSid=' +proSid, function(data){
               alert(data)
               $('#row'+ proSid).find('td').eq(2).text(data);
           });
       }

       $(function(){
            var len = 8; // 超過?個字以"..."取代
            $(".JQellipsis").each(function(i){
                if($(this).text().length>len){
                    $(this).attr("title",$(this).text());
                    var text=$(this).text().substring(0,len-1)+"...";
                    $(this).text(text);
                }
            });
        });
</script>
<?php include __DIR__. '/__html_foot.php';