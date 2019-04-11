<?php
require __DIR__. '/__connect_db.php';

$pname = 'index';
 
// session_start();
// print_r($_POST);

if(isset($_POST['manAccount'])){

    $doChecked = true;

    $sql = sprintf("SELECT `manAccount`, `manPassword`
            FROM `manager` WHERE `manAccount`=%s AND `manPassword`=%s",
            $pdo->quote($_POST['manAccount']),
            $pdo->quote($_POST['manPassword'])
        );
// echo $sql;exit;
    $stmt = $pdo->query($sql);
    
    if($stmt->rowCount()==1){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $row;


        header("Location:firstPage.php");
        exit;
    }
} else {

    unset($_SESSION['come_from']);
    if(!empty($_SERVER['HTTP_REFERER'])){
        $_SESSION['come_from'] = $_SERVER['HTTP_REFERER'];
        // 
    }
    // echo $_SERVER['HTTP_REFERER'];
}

?>

<style>

    body {
      background: #a3002d;
      font-family: "Helvetica", sans-sarif;
      font-size: 16px;
      color: #fcfff5; 
    }

    @import url('https://rsms.me/inter/inter-ui.css');
    ::selection {
      background: #ff5a81;
    }
    ::-webkit-selection {
      background: #ff5a81;
    }
    ::-moz-selection {
      background: #ff5a81;
    }

    .page {
      display: flex;
      flex-direction: column;
      height: calc(70% - 10px);
      position: absolute;
      place-content: center;
      width: calc(100% - 10px);
      left: 0;
    }
    @media (max-width: 767px) {
      .page {
        height: auto;
        margin-bottom: 20px;
        padding-bottom: 20px;
      }
    }
    .container {
      display: flex;
      height: 320px;
      margin: 0 auto;
      width: 640px;
    }
    @media (max-width: 767px) {
      .container {
        flex-direction: column;
        height: 630px;
        width: 320px;
      }
    }
    .left {
      background: white;
      height: calc(100% - 40px);
      top: 20px;
      position: relative;
      width: 50%;
    }
    @media (max-width: 767px) {
      .left {
        height: 100%;
        left: 20px;
        width: calc(100% - 40px);
        max-height: 270px;
      }
    }
    .login {
      font-size: 50px;
      font-weight: 900;
      margin: 50px 40px 40px;
    }
    .logman {
      color: #999;
      font-size: 14px;
      line-height: 1.5;
      margin: 40px;
    }
    .right {
      background: #474A59;
      box-shadow: 0px 0px 40px 16px rgba(0,0,0,0.22);
      color: #F1F1F2;
      position: relative;
      width: 50%;
    }
    @media (max-width: 767px) {
      .right {
        flex-shrink: 0;
        height: 100%;
        width: 100%;
        max-height: 350px;
      }
    }
    svg {
      position: absolute;
      width: 320px;
    }
    path {
      fill: none;
      stroke: url(#linearGradient);;
      stroke-width: 4;
      stroke-dasharray: 240 1386;
    }
    .login_p{
        font-size:16px;
        color:#0f0f0f;
    }
    .form {
      margin: 40px;
      position: absolute;
    }
    label {
      color:  #c2c2c5;
      display: block;
      font-size: 14px;
      height: 16px;
      margin-top: 20px;
      margin-bottom: 5px;
    }
    input {
      background: transparent;
      border: 0;
      color: #f2f2f2;
      font-size: 20px;
      height: 30px;
      line-height: 30px;
      outline: none !important;
      width: 100%;
    }
    input::-moz-focus-inner { 
      border: 0; 
    }
    #submit {
      color: #707075;
      margin-top: 40px;
      transition: color 300ms;
    }
    #submit:focus {
      color: #f2f2f2;
    }
    #submit:active {
      color: #d0d0d2;
    }
    .welcome {
      position: absolute;
      top: 580px;
      left: 0;
    }

  @import "compass/css3";

  @import url(https://fonts.googleapis.com/css?family=Lato:300,400,700|Dosis:200,400,600);

  body {
    background-color: #252527;
  }
  h1 {
    font-family: Dosis;
    font-weight: 200;
    position: absolute;
    text-align: center;
    display: block;
    color: #fff;
    top: 50%;
    width: 100%;
    margin-top: -55px;
    text-transform: uppercase;
    letter-spacing: 1px;
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    transform-style: preserve-3d;
    -webkit-transform: translate3d(0,0,0);
    -moz-transform: translate3d(0,0,0);
    transform: translate3d(0,0,0);
    opacity: 0;
    -webkit-animation: anim 3.2s ease-out forwards 1s;
    animation: anim 3.2s ease-out forwards 1s;
  }
  strong {
    display: block;
    font-weight: 400;
  }


  @-webkit-keyframes anim {
    0% {
      text-shadow: 0 0 50px #fff;
      letter-spacing: 80px;
      opacity: 0;
      -webkit-transform: rotateY(-90deg);
    }
    50% {
      text-shadow: 0 0 1px #fff;
      opacity: 0.8;
      -webkit-transform: rotateY(0deg);
    }
    75% {
      text-shadow: 0 0 1px #fff;
      opacity: 0.8;
      -webkit-transform: rotateY(0deg) translateZ(60px);
    }
    100% {
      text-shadow: 0 0 1px #fff;
      opacity: 0.8;
      letter-spacing: 8px;
      -webkit-transform: rotateY(0deg) translateZ(100px);
    }

  }
  @keyframes anim {
    0% {
      text-shadow: 0 0 50px #fff;
      letter-spacing: 80px;
      opacity: 0;
      -moz-transform: rotateY(-90deg);
    }
    50% {
      text-shadow: 0 0 1px #fff;
      opacity: 0.8;
      -moz-transform: rotateY(0deg);
    }
    75% {
      text-shadow: 0 0 1px #fff;
      opacity: 0.8;
      -moz-transform: rotateY(0deg) translateZ(60px);
    }
    100% {
      text-shadow: 0 0 1px #fff;
      opacity: 0.8;
      letter-spacing: 8px;
      -moz-transform: rotateY(0deg) translateZ(100px);
    }

  }
</style>

<div class="container">

    <?php if(isset($doChecked)):  ?>
        <?php if(isset($_SESSION['user'])):  ?>    
          
            <script>
                var come_from = "<?php 
                echo empty($_SESSION['come_from']) ?  '_db_index.php' :  'case_control.php';
                unset($_SESSION['come_from']);
                ?>";
                setTimeout(function(){
                      location.href = come_from;
                }, 4000);
            </script>
        <?php else: ?>
            <div id="main_alert" class="alert alert-danger" role="alert">
                帳號或密碼錯誤
            </div>
        <?php endif;  ?>
    <?php endif;  ?>

    <div class="page">
      <div class="container">
        <div class="left">
          <div class="login"><p class="login_p">輸入您的帳號密碼</p></div>
          <div class="logman">登入您的管理者帳號<br/>
                              開始管理ININSPORT</div>
         </div>
        
        <div class="right">
          <svg viewBox="0 0 320 300">
            <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
          </svg>
          <form action="" method="post">
          <div class="form">
            <label for="name">帳號</label>
            <input type="text" id="name" name="manAccount">
            <label for="password">密碼</label>
            <input type="password" id="password" name="manPassword">

            <?php if(isset($doChecked)): ?>
                <?php if(isset($_SESSION['user'])):  ?>
                <?php endif;  ?>
            <?php else: ?>
                <button type="submit" class="btn btn-primary login_btn">登入</button>
            <?php endif?>
            <!-- <button type="submit" class="btn btn-primary login_btn" href="logout.php">登出</button> -->
            
          </div>
          </form>
        </div>
        
      </div>
      
    </div>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  crossorigin="anonymous"></script>
    <script>
    let myform = $('#myform');

    function checkForm(){
        let isPass = true;

        if(! myform[0].account.value){
            isPass = false;
            alert('請填寫帳號');
        }

        if(! myform[0].keywords.value){
            isPass = false;
            alert('請填寫密碼');
        }

        return isPass;

    }

</script>