<!DOCTYPE html>
<html lang="vi">

<head>
    <?php include 'meta.php' ?>
    <title>login</title>
    <?php include 'css.php' ?>
</head>

<body>

    <?php include 'header.php' ?>
    <!-- <?php include 'header-child.php' ?> -->

    <div class="login">
        <div class="container">
            <div class="top text-center">
                <p class="medium-purple">Đăng nhập</p>
            </div>
            <form action="#" class="login-form rounded-form">
                <input type="email" class="main-input" placeholder="Email..." name="email">
                <input type="password" class="main-input" placeholder="Mật khẩu..." name="fullname">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <input class="remember-pass" type="checkbox" name="remember-pass" id="remember-pass">
                        <label for="remember-pass">Ghi nhớ</label>
                    </div>
                    <a href="#" type="submit" class="button">Đăng nhập</a>
                </div>
                <div class="bottom-box d-flex justify-content-center flex-wrap">
                    <div>
                        <span>Quên mật khẩu?</span>
                        <a href="forgot-pass.php">Khôi phục</a>
                    </div>
                    <div>
                        <span>Chưa có tài khoản?</span>
                        <a href="signup.php">Đăng ký</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php' ?>
    <?php include 'js.php' ?>

</body>

</html>