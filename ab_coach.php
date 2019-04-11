<?php
require __DIR__. '/__connect_db.php';
$pname = 'coach'; // 自訂的頁面名稱

$per_page = 10; //每頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // 第幾頁

$t_sql = "SELECT COUNT(1) FROM coach";
$total_rows = $pdo->query($t_sql)->fetch()[0]; //總筆數
$total_pages = ceil($total_rows/$per_page); //總頁數

// 限定頁碼範圍
if($page<1){
    header('Location: ab_coach.php');
    exit;
}
if($page>$total_pages){
    header('Location: ab_coach.php?page='. $total_pages);
    exit;
} 

// $sql = sprintf("SELECT * FROM coach ORDER BY coaSid DESC LIMIT %s, %s",($page-1)*$per_page, $per_page);
$sql = sprintf("SELECT 
                coaSid,
                coach.memSid,
                memActive,
                coach.memName,
                coaEdu,
                coaMaj,
                coaSport,
                coaLicense, 
                coaInfo, 
                coaImg, 
                coaCreated,
                (SELECT levName FROM levmem WHERE levSid = members.memActive ) as 'levName'
                FROM coach  JOIN members on members.memSid = coach.memSid",($page-1)*$per_page, $per_page);
$stmt = $pdo->query($sql);
?>

<style>
    .ge-classImg {
        width: 150px;
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
            <th scope="col">修改資料</th>
            <th scope="col">#</th>
            <th scope="col">權限修改</th>
            <th scope="col">權限</th>
            <th scope="col">姓名</th>
            <th scope="col">教育程度</th>
            <th scope="col">專業</th>
            <th scope="col">教學運動項目</th>
            <th scope="col">證照</th>
            <th scope="col">簡介</th>
            <th scope="col">頭像</th>
            <th scope="col">創立時間</th>
            <th scope="col">del</th>
        </tr>
        </thead>
        <tbody>
        <?php while($r = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr id="row<?= $r['memSid'] ?>">
            <td><a href="ab_edit.php?coaSid=<?= $r['coaSid'] ?>"><i class="fas fa-edit"></i></a></td>
            <td scope="row"><?= $r['coaSid'] ?></td>
            <td><a href="javascript:change_active(<?= $r['memSid'] ?>)"><i class="fas fa-edit"></i></a></td>
            <td><?= $r['levName'] ?></td>
            <!-- <td class="memActive"> </td> -->
            <td><?= $r['memName'] ?></td>
            <td><?= $r['coaEdu'] ?></td>
            <td><?= $r['coaMaj'] ?></td>
            <td><?= $r['coaSport'] ?></td>
            <td><?= $r['coaLicense'] ?></td>
            <td><?= $r['coaInfo'] ?></td>
            <td class="ge-classImg"><img class="coaImg" src="http://localhost:3000/images/<?= $r['coaImg']?>" alt="Card image cap">
            <td><?= $r['coaCreated'] ?></td>
            <td><a href="javascript:del_it(<?= $r['coaSid'] ?>)"><i class="fas fa-trash-alt"></i></a></td>
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
        function del_it(coaSid){
            if(confirm('你確定要刪除編號為 '+coaSid+' 的資料嗎?')){
                location.href = 'ab_del.php?coaSid=' + coaSid;
            }
        }
 
     //權限修改
        // function change_active(memSid){
        // alert(memSid)
        //     $.get('change.php?memSid='+ memSid, function(data){
                
        //         $('#row'+ memSid).find('td').eq(3).text(data);
        //     });
        // }
        function change_active(memSid){
          // alert(memSid)
          
           $.get('change.php?memSid='+memSid, function(data){
               //alert(data)
               $('#row'+memSid).find('td').eq(3).text(data);
           });
       }
        // function getActive(memActive){
        //     console.log(memActive)
        //    if(memActive == 1){
        //     $(".memActive").text("一般會員")
        //    } else{
        //     $(".memActive").text("教練")
        //     }
        // }

</script>
<?php include __DIR__. '/__html_foot.php';