<!DOCTYPE html>
<html lang="vi">

<head>
    <?php include 'meta.php' ?>
    <title>forgot pass</title>
    <?php include 'css.php' ?>
</head>

<body>

    <?php include 'header.php' ?>
    <!-- <?php include 'header-child.php' ?> -->

    <div class="forgot-pass">
        <div class="container">
            <div class="top text-center">
                <p class="medium-purple">Khôi phục mật khẩu</p>
            </div>
            <form action="#" class="forgot-pass-form rounded-form">
                <input type="email" class="main-input" placeholder="Email..." name="email">
                <div class="d-flex justify-content-center">
                    <a href="#" type="submit" class="button">Khôi phục</a>
                </div>
                <div class="bottom-box d-flex justify-content-center flex-wrap">
                    <div>
                        <span>Đã nhớ mật khẩu?</span>
                        <a href="login.php">Quay lại đăng nhập</a>
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