<?php
require __DIR__. '/__connect_db.php';
$pname = 'members'; // 自訂的頁面名稱

$per_page = 10; //每頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // 第幾頁

$t_sql = "SELECT COUNT(1) FROM members";
$total_rows = $pdo->query($t_sql)->fetch()[0]; //總筆數
$total_pages = ceil($total_rows/$per_page); //總頁數

// 限定頁碼範圍
if($page<1){
    header('Location: ab_member.php');
    exit;
}
if($page>$total_pages){
    header('Location: ab_member.php?page='. $total_pages);
    exit;
} 

$sql = sprintf("SELECT
                memSid,
                memActive,
                memEmail,
                memPassword,
                memName,
                memGender,
                memBirthday,
                memNickname,
                memMobile,
                memSport,
                memEachSport,
                memFavCity,
                memFavArea,
                memCity,
                memArea,
                memAddress,
                memImage,
                (SELECT levName FROM levmem WHERE levSid = members.memActive ) as 'levName' 
                FROM members ORDER BY memSid DESC LIMIT %s, %s",($page-1)*$per_page, $per_page);
$stmt = $pdo->query($sql);
?>
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
            <th scope="col">Email</th>
            <th scope="col">密碼</th>
            <th scope="col">姓名</th>
            <th scope="col">性別</th>
            <th scope="col">生日</th>
            <th scope="col">暱稱</th>
            <th scope="col">手機</th>
            <th scope="col">喜好運動</th>
            <th scope="col">喜好運動二</th>
            <th scope="col">偏好地點</th>
            <th scope="col">聯絡地點</th>
            <th scope="col">頭像</th>
            <th scope="col">del</th>
        </tr>
        </thead>
        <tbody>
        <?php while($r = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr id="row<?= $r['memSid'] ?>">
            <td><a href="ab_edit.php?memSid=<?= $r['memSid'] ?>"><i class="fas fa-edit"></i></a></td>
            <td scope="row"><?= $r['memSid'] ?></td>
            <td><a href="javascript:change_active(<?= $r['memSid'] ?>)"><i class="fas fa-edit"></i></a></td>
            <td><?= $r['levName'] ?></td>
            <td><?= $r['memEmail'] ?></td>
            <td><?= $r['memPassword'] ?></td>
            <td><?= $r['memName'] ?></td>
            <td><?= $r['memGender'] ?></td>
            <td><?= $r['memBirthday'] ?></td>
            <td><?= $r['memNickname'] ?></td>
            <td><?= $r['memMobile'] ?></td>
            <td><?= $r['memSport'] ?></td>
            <td><?= $r['memEachSport'] ?></td>
            <td><?= $r['memFavCity'].$r['memFavArea'] ?></td>
            <td><span class="JQellipsis"><?= $r['memCity'].$r['memArea'].$r['memAddress'] ?></span></td>
            <td><?= $r['memImage'] ?></td>
            <td><a href="javascript:del_it(<?= $r['memSid'] ?>)"><i class="fas fa-trash-alt"></i></a></td>
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
        function del_it(memSid){
            if(confirm('你確定要刪除編號為 '+memSid+' 的資料嗎?')){
                location.href = 'ab_del.php?memSid=' + memSid;
            }
        }

        //權限修改
        function change_active(memSid){
           
            $.get('change.php?memSid='+memSid, function(data){
                // alert(memSid)
                $('#row'+memSid).find('td').eq(3).text(data);
            });
        }

        //限制字數
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