<nav class="navbar navbar-expand-lg navbar-light bg-light container">
    <a class="navbar-brand" href="firstPage.php">ININ Sport</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

        <div class=" collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                
                <li class="nav-item <?= $pname=='list' ? 'active' : '' ?>">
                    <a class="nav-link" href="ab_listClass.php">課程列表</a>
                </li>
                <li class="nav-item <?= $pname=='list' ? 'active' : '' ?>">
                    <a class="nav-link" href="ab_listActivity.php">活動列表</a>
                </li>
                <li class="nav-item <?= $pname=='list' ? 'active' : '' ?>">
                    <a class="nav-link" href="ab_products.php">商品資料</a>
                </li>
                <li class="nav-item <?= $pname=='list' ? 'active' : '' ?>">
                    <a class="nav-link" href="ab_addPro.php">商品上架</a>
                </li>
                <li class="nav-item <?= $pname=='member' ? 'active' : '' ?>">
                    <a class="nav-link" href="ab_member.php">會員資料</a>
                </li>
                <li class="nav-item <?= $pname=='index' ? 'active' : '' ?>">
                    <a class="nav-link" href="ab_coach.php">教練資料</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">登出</a>
                </li>
            </ul>
        </div>
</nav>      
<style>
    .navbar-light .navbar-nav .active > .nav-link {
        color: white;
        background-color: #005cbf;
    }
</style>
