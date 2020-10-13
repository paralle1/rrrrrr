<?php
session_start();
$mode = 'input';
$errmessage = array();
if( isset($_POST['back']) && $_POST['back'] ){
  // 何もしない
} else if( isset($_POST['confirm']) && $_POST['confirm'] ){
// 確認画面
if( !$_POST['user_name'] ) {
  $errmessage[] = "※名前を入力してください";
} else if( mb_strlen($_POST['user_name']) > 30 ){
  $errmessage[] = "※名前は30文字以内にしてください";
}
$_SESSION['user_name']	= htmlspecialchars($_POST['user_name'], ENT_QUOTES);

if( !$_POST['user_email'] ) {
  $errmessage[] = "※Eメールを入力してください";
} else if( mb_strlen($_POST['user_email']) > 200 ){
  $errmessage[] = "※Eメールは200文字以内にしてください";
} else if( !filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) ){
  $errmessage[] = "※メールアドレスが不正です";
}
$_SESSION['user_email']	= htmlspecialchars($_POST['user_email'], ENT_QUOTES);

if( !$_POST['user_message'] ){
  $errmessage[] = "※お問い合わせ内容を入力してください";
} else if( mb_strlen($_POST['user_message']) > 500 ){
  $errmessage[] = "※お問い合わせ内容は500文字以内にしてください";
}
$_SESSION['user_message'] = htmlspecialchars($_POST['user_message'], ENT_QUOTES);

if( $errmessage ){
  $mode = 'input';
} else {
  $mode = 'confirm';
}
} else if( isset($_POST['send']) && $_POST['send'] ){
// 送信ボタンを押したとき
$message  = "以下のお問い合わせを受け付けました。 \r\n"
          . "名前 : " . $_SESSION['user_name'] . "\r\n"
          . "Eメール : " . $_SESSION['user_email'] . "\r\n"
          . "お問い合わせ内容 :\r\n"
          . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['user_message']);
$header = 'from: mail@extremefilms.jp';
mail($_SESSION['user_email'],'【rrrrrr】お問い合わせありがとうございます。',$message,$header);
mail('ryutam1@yahoo.co.jp','【rrrrrr】お問い合わせありがとうございます。',$message,$header);
$_SESSION = array();
$mode = 'send';
} else {
$_SESSION['user_name']    = "";
$_SESSION['user_email']   = "";
$_SESSION['user_message'] = "";
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>rrrrrr DEMO SITE</title>
  <meta name="description" content="rrrrrr DEMO SITE">
  <meta name="viewport" content="width=1024">
  <link rel="icon" href="favicon.ico">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>

  <div class="wrap">

    <div class="topbar">
      <a href="index.html"><img src="img/rrrrrr-title.png" width="247px" height="21px"></a>
      <div class="menu">
        <ul>
          <li><a href="about.html">ABOUT</a></li>
          <li><a href="work.html">WORK</a></li>
          <li><a href="community.html">COMMUNITY</a></li>
          <li class="current"><a href="support.php">SUPPORT</a></li>
          <li><a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram fa-2x"></i></a></li>
          <li><a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube fa-2x"></i></a></li>
        </ul>
      </div>
    </div>

    <div class="header-child">
      <img class="header-bg" src="https://picsum.photos/1800/1200">
    </div>

    <div class="menu-2">
      <ul>
        <li><a href="#inquiry"><i class="fas fa-equals fa-8x"></i><p>INQUIRY</p></a></li>
        <li><a href="#access"><i class="fas fa-map-signs fa-8x"></i><p>ACCESS</p></a></li>
      </ul>
    </div>

        <section class="support">

        <?php if( $mode =='input' ){ ?>

          <!-- 入力画面   -->

            <a name="inquiry"><form action="./support.php" method="post" novalidate></a>

              <h1>INQUIRY</h1>

              <div class="support-item">
                <?php
                  if( $errmessage ){
                    echo '<div style="color:red;">';
                    echo implode('<br>', $errmessage );
                    echo '</div>';
                  }
                ?>
              </div>

              <div class="support-item">
                <label class="label" for="name">お名前</label>
                <input class="inputs" type="text" id="name" name="user_name" value="<?php echo $_SESSION['user_name'] ?>">
              </div>

              <div class="support-item">
                <label class="label" for="mail">メールアドレス</label>
                <input class="inputs" type="email" id="mail" name="user_email" value="<?php echo $_SESSION['user_email'] ?>">
              </div>

              <!-- <div class="item">
                <p class="label">お問い合わせ項目</p>
                <div class="inputs">
                <input id="photo" type="radio" name="menu" value="cut"><label for="photo">PHOTO</label>
                <input id="video" type="radio" name="menu" value="video"><label for="cut-color">VIDEO</label>
                <input id="other" type="radio" name="menu" value="other"><label for="headspa">OTHER</label>
                </div>
              </div> -->

              <div class="support-item">
                <label class="label" for="msg">内容</label>
                <textarea class="inputs" spellcheck="false" id="msg" name="user_message"><?php echo $_SESSION['user_message'] ?></textarea>
              </div>

              <div class="btn-area">
                <input type="submit" name="confirm" value="確認"><input type="reset" name="reset" value="リセット">
              </div><br>

              <a name="access"><h1>ACCESS</h1></a>

              <hr>

              <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3323.4519470823498!2d130.34979051520293!3d33.59357628073321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x354193aa25409aff%3A0xf8545ab49ce7f45c!2z44CSODE0LTAwMDEg56aP5bKh55yM56aP5bKh5biC5pep6Imv5Yy655m-6YGT5rWc77yS5LiB55uu77yT4oiS77yS77yW!5e0!3m2!1sja!2sjp!4v1601465156904!5m2!1sja!2sjp" width="460" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

                <hr>

                <p>〒814-0001 福岡県福岡市早良区百道浜２丁目３−２６</p>
                <p>000-000-0000</p>
              </div>

            </form>

        <?php } else if( $mode == 'confirm'){ ?>

          <!-- 確認画面 -->
          <form action="./support.php" method="post" novalidate>
            <label class="label" for="name">お名前</label>
            <?php echo $_SESSION['user_name'] ?><br><br>
            <label class="label" for="mail">メールアドレス</label>
            <?php echo $_SESSION['user_email'] ?><br><br>
            <label class="label" for="msg">内容</label><br><br>
            <?php echo nl2br($_SESSION['user_message']) ?><br><br>
            <input type="submit" name="back" value="戻る" />
            <input type="submit" name="send" value="送信" />

          </form>

        <?php } else { ?>

          <form action="./support.php">
            <div class="send">
              <br><br><br><br>
              送信しました。お問い合わせありがとうございました <br><br><br><br><br>
            </div>
          </form>

        <?php } ?>

    </section>

    <footer>
      <div class="footer-bg">
        <div class="footerbar">
          <ul class="footer-menu">
            <li><a href="#">HOME</a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li><a href="work.html">WORK</a></li>
            <li><a href="community.html">COMMUNITY</a></li>
            <li><a href="support.php">SUPPORT</a></li>
            <li><a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram fa-2x"></i></a></li>
            <li><a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube fa-2x"></i></a></li>
          </ul>
        </div>
        <p>&copy; All right reserved by rrrrrr 2020.<p>
      </div>
    </footer>

    <p id="PageTopBtn"><a href="#"><i class="fas fa-arrow-up fa-2x"></i></a></p>

  </div>

</body>
</html>
