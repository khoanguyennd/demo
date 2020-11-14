<!DOCTYPE html>
<html lang="vi">

<head>
    <?php include 'meta.php' ?>
    <title>signup</title>
    <?php include 'css.php' ?>
</head>

<body>

    <?php include 'header.php' ?>
    <!-- <?php include 'header-child.php' ?> -->

    <div class="signup">
        <div class="container">
            <div class="top text-center">
                <p class="medium-purple">Đăng ký</p>
            </div>
            <form action="#" class="signup-form rounded-form">
                <input type="email" class="main-input" placeholder="Email..." name="email">
                <input type="password" class="main-input" placeholder="Mật khẩu..." name="password">
                <input type="password" class="main-input" placeholder="Nhập lại mật khẩu..." name="repassword">
                <div class="captcha">
                    <input type="text" class="main-input" placeholder="Captcha..." name="captcha">
                    <div>
                        <img class="captcha-img" src="img/captcha.png" alt="">
                        <a href="#">
                            <img class="refresh-img" src="img/refresh.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="#" type="submit" class="button">Đăng ký</a>
                </div>
                <div class="bottom-box d-flex justify-content-center flex-wrap">
                    <div>
                        <span>Đã có tài khoản?</span>
                        <a href="login.php">Đăng nhập</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php' ?>
    <?php include 'js.php' ?>

</body>

</html>